<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    use HasFactory;

    // If the table name is not the default "uploaded_files", keep this; otherwise, remove.
    protected $table = 'uploaded_files';

    // If your primary key is 'files_id' instead of 'id', keep these lines:
    protected $primaryKey = 'files_id';
    public $incrementing = true;
    protected $keyType = 'int';

    // If you want route model binding to use 'files_id', keep this:
    public function getRouteKeyName()
    {
        return 'files_id';
    }

    protected $fillable = ['software_id', 'original_name', 'path'];

    public function software()
    {
        return $this->belongsTo(Software::class, 'software_id', 'software_id');
    }
}
