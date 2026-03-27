<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('denda', function (Blueprint $table) {
            // Menyimpan order_id Midtrans untuk verifikasi callback
            $table->string('midtrans_order_id')->nullable()->unique()->after('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('denda', function (Blueprint $table) {
            $table->dropColumn('midtrans_order_id');
        });
    }
};
