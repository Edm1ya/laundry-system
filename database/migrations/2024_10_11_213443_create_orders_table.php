<?php

use App\Models\Customer;
use App\Models\Service;
use App\Models\Washer;
use App\OrderStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->foreignIdFor(Washer::class)->constrained();
            $table->integer('garment_quantity');
            $table->foreignIdFor(Service::class)->constrained();
            $table->float('total_price');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'canceled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
