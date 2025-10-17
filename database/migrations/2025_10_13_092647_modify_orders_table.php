<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'seller_id')) {
                $table->dropForeign(['seller_id']);
                $table->dropColumn('seller_id');
            }
            if (Schema::hasColumn('orders', 'subtotal_cents')) {
                $table->dropColumn('subtotal_cents');
            }
            if (Schema::hasColumn('orders', 'commission_percent')) {
                $table->dropColumn('commission_percent');
            }
            if (Schema::hasColumn('orders', 'commission_cents')) {
                $table->dropColumn('commission_cents');
            }
            if (Schema::hasColumn('orders', 'receipt_url')) {
                $table->dropColumn('receipt_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->integer('subtotal_cents')->nullable();
            $table->integer('commission_percent')->nullable();
            $table->integer('commission_cents')->nullable();
            $table->string('receipt_url')->nullable();
        });
    }
};