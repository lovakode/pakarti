<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'code', 'name', 'email', 'birth_date', 'birth_place', 'blood_type', 'gender', 
        'marital_status', 'religion', 'mother_name', 'addressline1', 'addressline2', 'state', 
        'city', 'zipcode', 'country', 'phone', 'mobile', 'emergency_contact_name', 
        'emergency_contact_phone', 'emergency_contact_relationship', 'last_education', 
        'department_id', 'subdirectorate', 'grade_id', 'job_position_id', 'superior_id', 
        'status', 'ptkp', 'join_date', 'exit_date', 'expertise_id'
    ];

    protected $appends = [];

    public function grade()
    {
        return $this->belongsTo(Settings\Grade::class, 'grade_id');
    }

    public function department()
    {
        return $this->belongsTo(Settings\Department::class, 'department_id');
    }

    public function job_position()
    {
        return $this->belongsTo(Settings\JobPosition::class, 'job_position_id');
    }
    
    public function expertise()
    {
        return $this->belongsTo(Settings\Expertise::class, 'expertise_id');
    }
    
    public function getImagePathAttribute()
    {
        // Pastikan kolom 'image' ada dalam hasil query
        if (!array_key_exists('image', $this->attributes)) {
            return null; // Tidak menambahkan attribute jika kolom 'image' tidak ada
        }
        
        // Cek apakah gambar ada di storage
        if ($this->image && file_exists(public_path($this->image))) {
            return $this->image;
        }
        
        return '/images/placeholders/avatar.png';
    }

    public function toArray()
    {
        $array = parent::toArray();

        // Tambahkan 'image_path' hanya jika kolom 'image' ada dalam query
        if (array_key_exists('image', $this->attributes)) {
            $array['image_path'] = $this->image_path;
        }

        return $array;
    }
}
