<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Smalot\PdfParser\Parser;

class FileAuditService
{
    /**
     * Audita um arquivo gerando hash, mime type e extraindo metadados específicos do formato.
     *
     * @param string $fullPath Caminho completo físico do arquivo no servidor.
     * @param string $originalName Nome original do arquivo.
     * @return array
     */
    public static function auditFile(string $fullPath, string $originalName): array
    {
        if (!file_exists($fullPath)) {
            return [
                'hash' => null,
                'mime_type' => null,
                'meta' => [
                    'error' => 'Arquivo fisico nao encontrado para auditoria.',
                    'summary' => 'Arquivo nao encontrado.'
                ]
            ];
        }

        // Aumenta temporariamente o limite de memória e tempo do PHP para processar arquivos grandes
        @ini_set('memory_limit', '2048M');
        @set_time_limit(180);

        try {
            $hash = hash_file('sha256', $fullPath);
            $mimeType = File::mimeType($fullPath);
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            $meta = [
                'file_system' => [
                    'absolute_path' => $fullPath,
                    'size_bytes' => file_exists($fullPath) ? filesize($fullPath) : 0,
                    'created_at' => file_exists($fullPath) ? date('d/m/Y H:i:s', filectime($fullPath)) : null,
                    'modified_at' => file_exists($fullPath) ? date('d/m/Y H:i:s', filemtime($fullPath)) : null,
                ],
            ];
            $summary = "";

            // 1. Planilhas (Excel e CSV)
            if (in_array($extension, ['xlsx', 'xls', 'csv', 'ods']) || str_contains($mimeType, 'spreadsheet') || str_contains($mimeType, 'csv') || str_contains($mimeType, 'excel')) {
                try {
                    $reader = IOFactory::createReaderForFile($fullPath);
                    $reader->setReadDataOnly(true);
                    $spreadsheet = $reader->load($fullPath);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $highestColumn = $worksheet->getHighestColumn();
                    $highestRow = $worksheet->getHighestRow();
                    
                    // Converter a letra da coluna mais alta para o índice numérico
                    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
                    $maxColumnsToRead = min($highestColumnIndex, 100);

                    // Heurística para descobrir qual linha contém o cabeçalho real (pesquisa entre as linhas 1 e 10)
                    $headerRowIndex = 1;
                    for ($r = 1; $r <= 10; ++$r) {
                        if ($r > $highestRow) {
                            break;
                        }
                        $filledInRow = 0;
                        for ($col = 1; $col <= $maxColumnsToRead; ++$col) {
                            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                            $val = $worksheet->getCell($colLetter . $r)->getValue();
                            if ($val !== null && $val !== '') {
                                $filledInRow++;
                            }
                        }
                        if ($filledInRow >= 2) {
                            $headerRowIndex = $r;
                            break;
                        }
                    }

                    // Ler os cabeçalhos das colunas
                    $headers = [];
                    for ($col = 1; $col <= $maxColumnsToRead; ++$col) {
                        $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                        $val = $worksheet->getCell($colLetter . $headerRowIndex)->getValue();
                        if ($val !== null && $val !== '') {
                            $headers[] = (string) $val;
                        }
                    }

                    $totalRows = $highestRow > $headerRowIndex ? $highestRow - $headerRowIndex : 0;
                    $sheetNames = $spreadsheet->getSheetNames();
                    $sheetsCount = $spreadsheet->getSheetCount();

                    $meta['spreadsheet'] = [
                        'headers' => $headers,
                        'total_rows' => $totalRows,
                        'total_columns' => $highestColumn,
                        'sheets_count' => $sheetsCount,
                        'sheet_names' => $sheetNames,
                    ];

                    $summary = sprintf(
                        "Planilha Excel/CSV com %d abas. Aba ativa possui %d registros e colunas: %s.",
                        $sheetsCount,
                        $totalRows,
                        implode(', ', $headers)
                    );
                } catch (\Exception $e) {
                    Log::error("Erro na auditoria de planilha: " . $e->getMessage());
                    $meta['spreadsheet']['error'] = $e->getMessage();
                    $summary = "Planilha Excel/CSV (Erro na leitura dos dados: " . $e->getMessage() . ").";
                }
            }
            // 2. Documentos PDF
            elseif ($extension === 'pdf' || $mimeType === 'application/pdf') {
                try {
                    $parser = new Parser();
                    $pdf = $parser->parseFile($fullPath);
                    $details = $pdf->getDetails();
                    
                    $title = self::sanitizeUtf8($details['Title'] ?? null);
                    $subject = self::sanitizeUtf8($details['Subject'] ?? null);
                    $keywords = self::sanitizeUtf8($details['Keywords'] ?? null);
                    $author = self::sanitizeUtf8($details['Author'] ?? null);
                    $creator = self::sanitizeUtf8($details['Creator'] ?? null);
                    $producer = self::sanitizeUtf8($details['Producer'] ?? null);
                    $creationDateRaw = $details['CreationDate'] ?? null;
                    $modDateRaw = $details['ModDate'] ?? null;
                    
                    $creationDate = self::parsePdfDate($creationDateRaw);
                    $modDate = self::parsePdfDate($modDateRaw);

                    $pagesList = method_exists($pdf, 'getPages') ? $pdf->getPages() : [];
                    $pages = count($pagesList);

                    $isSearchable = false;
                    $textSample = "";
                    if ($pages > 0) {
                        try {
                            $firstPageText = trim($pagesList[0]->getText());
                            $sanitizedPageText = self::sanitizeUtf8($firstPageText);
                            $cleanText = preg_replace('/\s+/', ' ', $sanitizedPageText);
                            if (strlen($cleanText) > 5) {
                                $isSearchable = true;
                                $textSample = mb_substr($cleanText, 0, 150) . (strlen($cleanText) > 150 ? '...' : '');
                            }
                        } catch (\Exception $e) {
                            Log::warning("Erro ao tentar ler texto da primeira página do PDF: " . $e->getMessage());
                        }
                    }

                    $pdfVersion = null;
                    if ($fh = @fopen($fullPath, 'r')) {
                        $firstLine = fgets($fh, 50);
                        fclose($fh);
                        if (preg_match('/%PDF-\d+\.\d+/', $firstLine, $matches)) {
                            $pdfVersion = trim($matches[0]);
                        }
                    }

                    $meta['pdf'] = [
                        'title' => $title,
                        'subject' => $subject,
                        'keywords' => $keywords,
                        'author' => $author,
                        'creator' => $creator,
                        'producer' => $producer,
                        'creation_date' => $creationDate,
                        'modification_date' => $modDate,
                        'pages_count' => $pages,
                        'pdf_version' => $pdfVersion,
                        'is_searchable' => $isSearchable,
                        'text_sample_first_page' => $textSample ? (string) $textSample : null,
                    ];

                    $summaryList = [];
                    if ($pages) $summaryList[] = "{$pages} páginas";
                    $summaryList[] = $isSearchable ? "Texto digital (Pesquisável)" : "Imagem digitalizada (Não-pesquisável)";
                    if ($title) $summaryList[] = "Título: \"{$title}\"";
                    if ($author) $summaryList[] = "Autor: {$author}";
                    if ($creationDate) $summaryList[] = "Criado em: {$creationDate}";
                    if ($pdfVersion) $summaryList[] = "Versão: {$pdfVersion}";
                    
                    $summary = "Documento PDF (" . implode(', ', $summaryList) . ").";
                } catch (\Exception $e) {
                    Log::error("Erro na auditoria de PDF: " . $e->getMessage());
                    $meta['pdf']['error'] = $e->getMessage();
                    $summary = "Documento PDF (Erro ao extrair metadados: " . $e->getMessage() . ").";
                }
            }
            // 3. Imagens
            elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']) || str_contains($mimeType, 'image')) {
                try {
                    $meta['image'] = [];
                    $summaryParts = [];

                    $width = null;
                    $height = null;
                    if ($imageSize = @getimagesize($fullPath)) {
                        $width = $imageSize[0] ?? null;
                        $height = $imageSize[1] ?? null;
                    }

                    $meta['image']['width'] = $width;
                    $meta['image']['height'] = $height;
                    if ($width && $height) {
                        $summaryParts[] = "Resolução: {$width}x{$height} px";
                    }

                    if (in_array($extension, ['jpg', 'jpeg']) && function_exists('exif_read_data')) {
                        $exif = @exif_read_data($fullPath);
                        if ($exif) {
                            $make = self::sanitizeUtf8($exif['Make'] ?? null);
                            $model = self::sanitizeUtf8($exif['Model'] ?? null);
                            $software = self::sanitizeUtf8($exif['Software'] ?? null);
                            $captureDateRaw = $exif['DateTimeOriginal'] ?? $exif['DateTime'] ?? null;

                            $captureDate = null;
                            if ($captureDateRaw && preg_match('/^(\d{4}):(\d{2}):(\d{2})\s+(\d{2}):(\d{2}):(\d{2})/', $captureDateRaw, $matches)) {
                                $captureDate = "{$matches[3]}/{$matches[2]}/{$matches[1]} {$matches[4]}:{$matches[5]}:{$matches[6]}";
                            } elseif ($captureDateRaw && preg_match('/^(\d{4}):(\d{2}):(\d{2})/', $captureDateRaw, $matches)) {
                                $captureDate = "{$matches[3]}/{$matches[2]}/{$matches[1]}";
                            } else {
                                $captureDate = self::sanitizeUtf8($captureDateRaw);
                            }

                            $iso = $exif['ISOSpeedRatings'] ?? null;
                            $exposureTime = $exif['ExposureTime'] ?? null;
                            $fNumber = $exif['FNumber'] ?? null;
                            $focalLength = $exif['FocalLength'] ?? null;

                            $meta['image'] = array_merge($meta['image'], [
                                'camera_make' => $make,
                                'camera_model' => $model,
                                'software' => $software,
                                'capture_date' => $captureDate,
                                'iso' => $iso,
                                'exposure_time' => $exposureTime,
                                'f_number' => $fNumber,
                                'focal_length' => $focalLength,
                            ]);

                            if ($make || $model) {
                                $summaryParts[] = "Câmera: " . trim("{$make} {$model}");
                            }
                            if ($software) {
                                $summaryParts[] = "Software: {$software}";
                            }
                            if ($captureDate) {
                                $summaryParts[] = "Capturada em: {$captureDate}";
                            }

                            if (isset($exif['GPSLatitude'], $exif['GPSLongitude'], $exif['GPSLatitudeRef'], $exif['GPSLongitudeRef'])) {
                                $lat = self::getGpsCoordinate($exif['GPSLatitude'], $exif['GPSLatitudeRef']);
                                $lon = self::getGpsCoordinate($exif['GPSLongitude'], $exif['GPSLongitudeRef']);
                                
                                $meta['image']['gps'] = [
                                    'latitude' => $lat,
                                    'longitude' => $lon,
                                ];
                                $summaryParts[] = "Coordenadas GPS: {$lat}, {$lon}";
                            }
                        }
                    }

                    $summary = "Imagem " . strtoupper($extension) . (count($summaryParts) > 0 ? " (" . implode(', ', $summaryParts) . ")" : "") . ".";
                } catch (\Exception $e) {
                    Log::error("Erro na auditoria de Imagem: " . $e->getMessage());
                    $meta['image']['error'] = $e->getMessage();
                    $summary = "Imagem " . strtoupper($extension) . " (Erro ao extrair EXIF: " . $e->getMessage() . ").";
                }
            }
            // 4. Outros
            else {
                $summary = "Arquivo Generico do tipo " . strtoupper($extension) . ".";
            }

            $meta['summary'] = $summary;

            return [
                'hash' => $hash,
                'mime_type' => $mimeType,
                'meta' => $meta,
            ];

        } catch (\Exception $e) {
            Log::error("Erro geral na auditoria do arquivo {$originalName}: " . $e->getMessage());
            return [
                'hash' => null,
                'mime_type' => null,
                'meta' => [
                    'error' => $e->getMessage(),
                    'summary' => "Erro ao processar o arquivo para auditoria: " . $e->getMessage()
                ]
            ];
        }
    }

    private static function getGpsCoordinate(array $coordinate, string $ref): float
    {
        $degrees = self::gpsCoordinatePartToFloat($coordinate[0] ?? '0/1');
        $minutes = self::gpsCoordinatePartToFloat($coordinate[1] ?? '0/1');
        $seconds = self::gpsCoordinatePartToFloat($coordinate[2] ?? '0/1');

        $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

        if (in_array(strtoupper($ref), ['S', 'W'])) {
            $decimal = -$decimal;
        }

        return round($decimal, 6);
    }

    private static function gpsCoordinatePartToFloat(string $part): float
    {
        $parts = explode('/', $part);
        if (count($parts) === 2) {
            if ((float)$parts[1] > 0) {
                return (float)$parts[0] / (float)$parts[1];
            }
        }
        return (float)$part;
    }

    private static function parsePdfDate(?string $pdfDate): ?string
    {
        if (!$pdfDate) return null;
        
        if (strpos($pdfDate, 'D:') === 0) {
            $pdfDate = substr($pdfDate, 2);
        }
        
        if (preg_match('/^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', $pdfDate, $matches)) {
            return "{$matches[3]}/{$matches[2]}/{$matches[1]} {$matches[4]}:{$matches[5]}:{$matches[6]}";
        }
        if (preg_match('/^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})/', $pdfDate, $matches)) {
            return "{$matches[3]}/{$matches[2]}/{$matches[1]} {$matches[4]}:{$matches[5]}";
        }
        if (preg_match('/^(\d{4})(\d{2})(\d{2})/', $pdfDate, $matches)) {
            return "{$matches[3]}/{$matches[2]}/{$matches[1]}";
        }
        
        return $pdfDate;
    }

    private static function sanitizeUtf8(?string $string): ?string
    {
        if ($string === null) return null;
        return mb_convert_encoding($string, 'UTF-8', 'UTF-8');
    }
}
