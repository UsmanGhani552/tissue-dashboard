<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet2 extends Model
{
    use HasFactory;

    protected $table = 'sheet2s';

    protected $fillable = [
        'name',
        'data'
    ];
}
