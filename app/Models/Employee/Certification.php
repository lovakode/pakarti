<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{

    protected $table = 'employee_certifications';

    protected $fillable = [
        'name', 'code', 'parent_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
