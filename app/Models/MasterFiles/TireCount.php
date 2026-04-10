<?php

namespace App\Models\MasterFiles;

use Illuminate\Database\Eloquent\Model;

class TireCount extends Model
{
    //
    protected $table = 'tire_counts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'tire_count',
        'count_description',
        'spare_count',
    ];

    public function tirePositions()
    {
        return $this->hasMany(TirePosition::class, 'tire_counts_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicles::class, 'tire_counts_id');
    }

}