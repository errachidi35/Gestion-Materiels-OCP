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
        Schema::create('order_item', function (Blueprint $table) {
            // $table->id();
            // $table->foreignId('order_id')->constrained();
            // $table->foreignId('material_id')->constrained();
            // $table->string('quantity');
            // $table->string('rate');
            // $table->string('total');
            // $table->string('order_item_state');
            // $table->timestamps();
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('material_id')->constrained();
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item');
    }
};
