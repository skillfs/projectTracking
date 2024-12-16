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
        'purpose',
        'status',
        'file',
        'date',
    ];
}
