<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up(): void {
    Schema::create('listings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // vendedor
        $table->string('title');
        $table->string('slug')->unique();
        $table->string('brand');
        $table->string('model');
        $table->integer('year');
        $table->integer('km');
        $table->integer('power_hp')->nullable();
        $table->integer('displacement_cc')->nullable();
        $table->enum('fuel', ['gasolina','electrica','hibrida'])->default('gasolina');
        $table->enum('condition', ['nueva','seminueva','usada'])->default('usada');
        $table->integer('price_cents');
        $table->enum('status', ['draft','pending_review','published','rejected','sold'])->default('pending_review');
        $table->string('location')->nullable();
        $table->text('description')->nullable();
        $table->timestamp('published_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
