<?php

namespace App\Models\MasterFiles;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'location_name',
        'location_address',
        'location_altername'
    ];

    public $timestamps = false;

    public function tires()
    {
        return $this->hasMany(Tires::class, 'locations_id');
    }
}
