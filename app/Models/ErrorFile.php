<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorFile extends Model
{
    use HasFactory;

    protected $table = 'error_files';
    protected $fillable = [
        'folder_id',
        'file_id',
        'file_name',
        'mime_type',
        'page_message',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true; // Ensure this is set

    public function folder() {
        return $this->belongsTo(Folder::class, 'folder_id');
    }
}
