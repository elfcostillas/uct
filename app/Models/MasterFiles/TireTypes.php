<?php

namespace App\Models\MasterFiles;

use Illuminate\Database\Eloquent\Model;

class TireTypes extends Model
{
    protected $table = 'tire_types';

    protected $primaryKey = 'id';

    protected $fillable = [
        'type_desc',
        
    ];

    public $timestamps = false;

    public function tires()
    {
        return $this->hasMany(Tires::class, 'tire_type_id');
    }
}
