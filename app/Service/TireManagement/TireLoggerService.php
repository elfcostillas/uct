<?php

namespace App\Service\TireManagement;

use App\Models\TireManagement\TireMovementLog;

class TireLoggerService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function log($model,$user=null)
    {
        // dd($model,$user);
        // dd($model->getChanges(),$model->getOriginal());

        $now = now();

        $self = new self();

        $before = $model->getOriginal();
        $after = $model->getChanges();

        $installed = array_values(array_filter($before,fn($value,$key) => str_contains($key, '_wheel_id') && $value !== null, ARRAY_FILTER_USE_BOTH));

        $tires = array_filter($after,fn($key) => str_contains($key, '_wheel_id'), ARRAY_FILTER_USE_KEY);

        foreach($tires as $key => $value){

            if(is_null($after[$key])){
                if(!is_null($before[$key])){
                    $self->uninstall($before,$after,$key,$user,$now); // uninstall tire [installed  => uninstall]
                }else{
                    continue;
                }
            }else{
                if(!is_null($before[$key])){
                    // $self->uninstall($before,$after,$key,$user,$now); // uninstall target position
                    // $self->install($before,$after,$key,$user,$now);
                  
                    if(in_array($after[$key],$installed)){
                        $self->uninstall_s($before,$after,$key,$user,$now); 
                        $self->uninstall($before,$after,$key,$user,$now); // uninstall target position
                        $self->install($before,$after,$key,$user,$now);
                    }else{
                        $self->uninstall($before,$after,$key,$user,$now);
                        $self->install($before,$after,$key,$user,$now);
                    }

                }else{
                    // [uninstalled => install]
                    $self->install($before,$after,$key,$user,$now); // uninstall target position
                }
            }

            // if(array_key_exists($key,$before)){
            //     if(!is_null($before[$key] )){
            //         $self->uninstall($before,$after,$key,$user,$now);
            //         $self->install($before,$after,$key,$user,$now);
            //     }else{
            //         $self->install($before,$after,$key,$user,$now);
            //     }
            // }
        }
        
    }

    public function uninstall($before,$after,$key,$user,$now)
    {
        $to_uninstall = [
                'vehicle_id' => $before['vehicle_id'],
                'action' => 'Uninstall',
                'odo' => $after['odometer_reading'],
                'hmr' => $after['hour_meter_reading'],
                'tire_id' => $before[$key],
                'log_timestamp' => $now,
                // 'user_id' => $user->id,
                'user_id' => (property_exists($user,'id')) ? $user->id : 0,
                'tire_position'=>  str_replace('_wheel_id', '', $key),
        ];

        TireMovementLog::firstOrCreate($to_uninstall,$to_uninstall);
    }

    public function uninstall_s($before,$after,$key,$user,$now)
    {
        // $to_uninstall = [
        //         'vehicle_id' => $before['vehicle_id'],
        //         'action' => 'Uninstall',
        //         'odo' => $after['odometer_reading'],
        //         'hmr' => $after['hour_meter_reading'],
        //         'tire_id' => $after[$key],
        //         'log_timestamp' => $now,
        //         // 'user_id' => $user->id,
        //         'user_id' => (property_exists($user,'id')) ? $user->id : 0,
        //         'tire_position'=>  str_replace('_wheel_id', '', $key.'s'),
        // ];

        $prev_key = array_search($after[$key],$before);

        $to_uninstall = [
                'vehicle_id' => $before['vehicle_id'],
                'action' => 'Uninstall',
                'odo' => $after['odometer_reading'],
                'hmr' => $after['hour_meter_reading'],
                'tire_id' => $after[$key],
                'log_timestamp' => $now,
                'user_id' => $user->id,
                // 'user_id' => (property_exists($user,'id')) ? $user->id : 0,
                'tire_position'=>  str_replace('_wheel_id', '', $prev_key),
        ];

        TireMovementLog::firstOrCreate($to_uninstall,$to_uninstall);
    }

    public function install($before,$after,$key,$user,$now)
    {
        $to_install = [
                'vehicle_id' => $before['vehicle_id'],
                'action' => 'Install',
                'odo' => $after['odometer_reading'],
                'hmr' => $after['hour_meter_reading'],
                'tire_id' => $after[$key],
                'log_timestamp' => $now,
                'user_id' => $user->id,
                // 'user_id' => (property_exists($user,'id')) ? $user->id : 0,
                'tire_position'=>  str_replace('_wheel_id', '', $key),
        ];

        TireMovementLog::firstOrCreate($to_install,$to_install);
    }

}
