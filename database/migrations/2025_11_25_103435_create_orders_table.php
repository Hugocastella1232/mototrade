<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('listing_id')->nullable();
            $table->string('status', 30);
            $table->integer('total_eur');
            $table->string('payment_provider')->default('stripe');
            $table->string('payment_intent_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};