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
    Schema::create('listing_photos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
        $table->string('path');     // storage/app/public/...
        $table->unsignedTinyInteger('position')->default(1); // 1..6
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_photos');
    }
};
