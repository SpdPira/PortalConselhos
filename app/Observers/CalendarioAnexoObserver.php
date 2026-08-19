<?php

namespace App\Observers;

use App\Models\CalendarioAnexo;
use App\Models\PublishedFile;

class CalendarioAnexoObserver
{
    /**
     * Handle the CalendarioAnexo "created" event.
     */
    public function created(CalendarioAnexo $calendarioAnexo): void
    {
        if ($calendarioAnexo->arquivo) {
            PublishedFile::auditAndLog($calendarioAnexo, $calendarioAnexo->arquivo, 'created');
        }
    }

    /**
     * Handle the CalendarioAnexo "updated" event.
     */
    public function updated(CalendarioAnexo $calendarioAnexo): void
    {
        if ($calendarioAnexo->isDirty('arquivo')) {
            if ($calendarioAnexo->arquivo) {
                PublishedFile::auditAndLog($calendarioAnexo, $calendarioAnexo->arquivo, 'updated');
            }
        }
    }

    /**
     * Handle the CalendarioAnexo "deleted" event.
     */
    public function deleted(CalendarioAnexo $calendarioAnexo): void
    {
        if ($calendarioAnexo->arquivo) {
            PublishedFile::auditAndLog($calendarioAnexo, $calendarioAnexo->arquivo, 'deleted');
        }
    }
}
