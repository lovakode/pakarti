<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    protected $table = 'mst_expertises';

    protected $fillable = [
        'name'
    ];

    public function employee()
    {
        return $this->hasMany(\App\Models\Employee::class, 'expertise_id');
    }
}
