<?php

namespace App\Observers;

use App\Models\Calendario;
use App\Models\PublishedFile;

class CalendarioObserver
{
    /**
     * Handle the Calendario "created" event.
     */
    public function created(Calendario $calendario): void
    {
        if ($calendario->arquivo) {
            PublishedFile::auditAndLog($calendario, $calendario->arquivo, 'created');
        }
    }

    /**
     * Handle the Calendario "updated" event.
     */
    public function updated(Calendario $calendario): void
    {
        if ($calendario->isDirty('arquivo')) {
            // Se o arquivo antigo for diferente, audita o novo
            if ($calendario->arquivo) {
                PublishedFile::auditAndLog($calendario, $calendario->arquivo, 'updated');
            }
        }
    }

    /**
     * Handle the Calendario "deleted" event.
     */
    public function deleted(Calendario $calendario): void
    {
        if ($calendario->arquivo) {
            PublishedFile::auditAndLog($calendario, $calendario->arquivo, 'deleted');
        }
    }
}
