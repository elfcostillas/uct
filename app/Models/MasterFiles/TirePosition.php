<?php

namespace App\Models\MasterFiles;

use Illuminate\Database\Eloquent\Model;

class TirePosition extends Model
{
        protected $table = 'tire_positions';   

        protected $primaryKey = 'id';

        protected $fillable = [
            'id',
            'tire_counts_id',
            'position_desc',
            'position_code',
        ];

        public function tireCount()
        {
            return $this->belongsTo(TireCount::class, 'tire_counts_id');
        }
}
