<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet1 extends Model
{
    use HasFactory;

    protected $table = 'sheet1s';

    protected $fillable = [
        'name',
        'data',
    ];
}
