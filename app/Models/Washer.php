<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Washer extends Model
{
    use HasFactory;

    protected $fillable = [
        "service_type",
        "garment_quantity",
        "in_use",
    ];
}
