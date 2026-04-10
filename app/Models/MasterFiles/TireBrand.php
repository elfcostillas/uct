<?php

namespace App\Models\MasterFiles;

use Illuminate\Database\Eloquent\Model;

class TireBrand extends Model
{
    protected $table = 'tire_brands';

    protected $primaryKey = 'id';

    protected $fillable = [
        'brand_name',
       
    ];

    public $timestamps = false;

    public function tires()
    {
        return $this->hasMany(Tires::class, 'tire_brand_id');
    }
}
