<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalisBsm2Sheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'sheet_id',
        'name'
    ];
}
