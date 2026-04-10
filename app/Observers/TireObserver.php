<?php

namespace App\Observers;

use App\Models\MasterFiles\Tires;
use App\Service\LogService; 

class TireObserver
{
    /**
     * Handle the Tires "created" event.
     */
    public function created(Tires $tires): void
    {
       
        LogService::log(
            'tires',
            'CREATE',
            $tires->toArray(),
            $tires->id,
            user: auth()->user()
        );
    }

    /**
     * Handle the Tires "updated" event.
     */
    public function updated(Tires $tires): void
    {
      
        LogService::log(
            'tires',
            'UPDATE',
            $tires->getChanges(),
            $tires->id,
            user: auth()->user()
        );
    }

    /**
     * Handle the Tires "deleted" event.
     */
    public function deleted(Tires $tires): void
    {
        //
    }

    /**
     * Handle the Tires "restored" event.
     */
    public function restored(Tires $tires): void
    {
        //
    }

    /**
     * Handle the Tires "force deleted" event.
     */
    public function forceDeleted(Tires $tires): void
    {
        //
    }
}
