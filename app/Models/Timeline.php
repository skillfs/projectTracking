<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $primaryKey = 'timeline_id';

    protected $fillable = [
        'timeline_regist_number',
        'timeline_date',
        'timeline_step',
    ];

    public function software()
    {
        return $this->belongsTo(Software::class, 'timeline_regist_number', 'software_id');
    }
}
