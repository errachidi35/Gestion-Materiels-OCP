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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->string('code');
            $table->string('location');
            $table->string('image')->nullable();
            $table->foreignId('brand')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('quantity');
            $table->string('used_quantity')->default(0);
            $table->string('global_quantity');
            $table->string('rate');
            $table->integer('state')->default(0);
            $table->integer('active')->default(1);
            $table->string('email');
            $table->string('website');
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
