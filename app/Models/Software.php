<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;

    protected $table = 'softwares'; // Explicitly set table name

    protected $primaryKey = 'software_id'; // Set custom primary key

    protected $fillable = [
        'f_name',
        'l_name',
        'department_id',
        'tel',
        'software_name',
        'problem',
        'target',
        'timeline_start',
        'timeline_end',
        'purpose',
        'status',
        'file',
        'date',
    ];

    protected $casts = [
        'timeline_start' => 'date',
        'timeline_end' => 'date',
        'file' => 'array',
    ];

    /**
     * Relationship to Department.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    /**
     * Relationship to Users.
     * เชื่อมโยงผ่าน department_id
     */
    public function users()
    {
        return $this->hasMany(User::class, 'department_id', 'department_id');
    }

    public function uploadedFiles()
    {
        return $this->hasMany(UploadedFile::class, 'software_id', 'software_id'); // Specify foreign key and local key
    }
}
