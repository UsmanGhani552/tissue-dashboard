<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalisBsm2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'submitter_id',
        'tracking_id',
        'ship_date',
        'bsm2_id',
        'created_at',
        'updated_at',
    ];
}
