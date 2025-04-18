<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    protected $table = 'mst_job_positions';

    protected $fillable = [
        'name'
    ];

    public function employee()
    {
        return $this->hasMany(\App\Models\Employee::class, 'job_position_id');
    }
}
