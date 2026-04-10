<?php

namespace App\Models\MasterFiles;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $table = 'manufacturers';

    protected $primaryKey = 'id';

    public function vehicles()
    {
        return $this->hasMany(Vehicles::class, 'manufacturer_id');  
    }
}
