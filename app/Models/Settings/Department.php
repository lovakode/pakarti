<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Department extends Model
{
    use NodeTrait;

    protected $table = 'mst_departments';

    protected $fillable = [
        'name', 'code', 'parent_id'
    ];

    public function employee()
    {
        return $this->hasMany(\App\Models\Employee::class, 'department_id');
    }
    
    public function getLftName()
    {
        return '_lft';
    }
    
    public function getRgtName()
    {
        return '_rgt';
    }
    
    public function getParentIdName()
    {
        return 'parent_id';
    }

    public function children(){
        return $this->descendants();
    }
    
    public function parent(){
        return $this->belongsTo(Department::class, 'parent_id');
    }
}
