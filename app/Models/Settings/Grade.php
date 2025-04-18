<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'mst_grades';

    protected $fillable = [
        'name'
    ];

    public function employee()
    {
        return $this->hasMany(\App\Models\Employee::class, 'grade_id');
    }
}
