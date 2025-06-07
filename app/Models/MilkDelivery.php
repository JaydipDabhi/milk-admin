<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'weight',
        'type',
        'rate',
        'total_rate',
        'time',
    ];

    protected $table = 'milk_delivery';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
