<?php

namespace App\Models\MasterFiles;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'emp_id',
        'biometric_id',
        'employee_name',
        'job_title'
    ];

    public $timestamps = false;

    public function vehicles()
    {
        return $this->hasMany(Vehicles::class, 'assigned_to');
    }   
}
