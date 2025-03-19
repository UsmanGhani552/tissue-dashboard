<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'drive_folder_id',
        'parent_folder_id'
    ];

    public function driveFolders() {
        return $this->hasMany(Folder::class,'parent_folder_id');
    }
    public function parentFolder() {
        return $this->belongsTo(Folder::class,'parent_folder_id');
    }
}
