<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::table('listings')->where('status', 'pendiente')->update(['status' => 'pending']);
        DB::table('listings')->where('status', 'aprobada')->update(['status' => 'approved']);
        DB::table('listings')->where('status', 'rechazada')->update(['status' => 'rejected']);
        DB::table('listings')->where('status', 'vendida')->update(['status' => 'sold']);
    }

    public function down()
    {
    }
};