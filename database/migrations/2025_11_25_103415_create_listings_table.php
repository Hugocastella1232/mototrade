<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->integer('km');
            $table->integer('power_hp')->nullable();
            $table->integer('displacement_cc')->nullable();
            $table->string('fuel', 30);
            $table->string('listing_condition', 30);
            $table->integer('price_eur');
            $table->string('status', 30);
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('listings');
    }
};