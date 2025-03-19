<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalisBsm extends Model
{
    use HasFactory;
    protected $table = 'personalis_bsms';
    protected $fillable = [
        'submitter_id',
        'letter',
        'commentor',
        'shipped_by',
        'ship_date',
        'bsm_id',
    ];
}
