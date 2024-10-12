<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'washer_id',
        'service_id',
        'garment_quantity',
        'service_type',
        'total_price',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function washer()
    {
        return $this->belongsTo(Washer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
