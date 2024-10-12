<?php

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
        Schema::create('washers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum("service_type", ["lavado", "planchado", "secado"]);
            $table->integer('garment_quantity');
            $table->boolean('in_use')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('washers');
    }
};
