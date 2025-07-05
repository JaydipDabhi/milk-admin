<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilkDairy extends Model
{
    protected $table = 'milk_dairy';
    protected $fillable = [
        'customer_no_in_dairy',
        'shift',
        'milk_weight',
        'fat_in_percentage',
        'rate_per_liter',
        'amount',
        'total_amount',
    ];
}
