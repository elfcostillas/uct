<?php

namespace App\Traits;

use App\Models\TireManagement\WheelPosition\VehicleWheelPosition;
use App\Service\LogService;
use App\Service\TireManagement\TireLoggerService;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            LogService::log(
                $model->getTable(),
                'CREATE',
                $model->toArray(),
                $model->getKey(),
                auth()->user()
            );

         
        });

        static::updated(function ($model) {
            LogService::log(
                $model->getTable(),
                'UPDATE',
                $model->getChanges(),
                $model->getKey(),
                auth()->user(),
                // $model->getOriginal()
            );

        
        });

        static::deleted(function ($model) {
            LogService::log(
                $model->getTable(),
                'DELETE',
                null,
                $model->getKey(),
                auth()->user(),
                $model->toArray()
            );
        });
    }
}

/*
namespace App\Traits;

use App\Service\LogService;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            LogService::log(
                $model->getTable(),
                'CREATE',
                $model->toArray(),
                $model->getKey(),
                auth()->user()
            );
        });

        static::updated(function ($model) {
            LogService::log(
                $model->getTable(),
                'UPDATE',
                $model->getChanges(),
                $model->getKey(),
                auth()->user(),
                $model->getOriginal()
            );
        });

        static::deleted(function ($model) {
            LogService::log(
                $model->getTable(),
                'DELETE',
                null,
                $model->getKey(),
                auth()->user(),
                $model->toArray()
            );
        });
    }
}*/
