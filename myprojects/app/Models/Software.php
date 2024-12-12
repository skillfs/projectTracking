<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;

    protected $table = 'software';

    protected $fillable = ['name', 'tel', 'software_name', 'date', 'problem', 'purpose', 'target', 'status'];
}
