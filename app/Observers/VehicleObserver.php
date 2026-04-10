<?php

namespace App\Observers;

use App\Models\MasterFiles\Vehicles;
use App\Service\LogService;

class VehicleObserver
{
    /**
     * Handle the Vehicle "created" event.
     */
    public function created(Vehicles $vehicle): void
    {
        LogService::log(
            'vehicles',
            'CREATE',
            $vehicle->toArray(),
            $vehicle->id,
            user: auth()->user()
        );
    }

    /**
     * Handle the Vehicle "updated" event.
     */
    public function updated(Vehicles $vehicle): void
    {
        LogService::log(
            'vehicles',
            'UPDATE',
            $vehicle->getChanges(),
            $vehicle->id,
            user: auth()->user()
        );
    }

    /**
     * Handle the Vehicle "deleted" event.
     */
    public function deleted(Vehicles $vehicle): void
    {
        //
    }

    /**
     * Handle the Vehicle "restored" event.
     */
    public function restored(Vehicles $vehicle): void
    {
        //
    }

    /**
     * Handle the Vehicle "force deleted" event.
     */
    public function forceDeleted(Vehicles $vehicle): void
    {
        //
    }
}
