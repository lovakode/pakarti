<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{

    protected $table = 'employee_families';

    protected $fillable = [
        'employee_id', 'code', 'parent_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
