<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{

    protected $table = 'employee_educations';

    protected $fillable = [
        'name', 'code', 'parent_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
