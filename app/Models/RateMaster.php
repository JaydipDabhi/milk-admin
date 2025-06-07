<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate_type',
        'rate',
    ];

    protected $table = 'rate_master';
}
