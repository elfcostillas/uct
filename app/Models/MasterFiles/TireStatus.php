<?php

namespace App\Models\MasterFiles;

use Illuminate\Database\Eloquent\Model;

class TireStatus extends Model
{
    protected $table = 'tire_status';

    protected $primaryKey = 'id';

    protected $fillable = [
        'status_desc',
        
    ];

    public $timestamps = false;

    public function tires()
    {
        return $this->hasMany(Tires::class, 'tire_status_id');
    }
}

