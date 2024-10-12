<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Washer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        "service_type",
        "garment_quantity",
        "in_use",
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
