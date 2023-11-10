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
        Schema::create('orders', function (Blueprint $table) {
            // $table->id();
            // $table->date('order_date');
            // $table->string('client_name');
            // $table->string('client_contact');
            // $table->string('sub_total');
            // $table->string('vat');
            // $table->string('total_amount');
            // $table->string('discount');
            // $table->string('grand_total');
            // $table->string('paid_amount');
            // $table->string('due_amount');
            // $table->integer('payment_type');
            // $table->integer('payment_state');
            // $table->integer('order_state');
            // $table->timestamps();
            $table->id();
            $table->string('client_name');
            $table->string('client_contact');
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
