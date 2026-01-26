<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('invoice')->nullable()->after('id');
            $table->string('nama')->nullable()->after('invoice');
            $table->string('no_hp')->nullable()->after('nama');
            $table->unsignedBigInteger('kapster_id')->nullable()->after('no_hp');
            $table->decimal('uang_bayar', 10, 2)->nullable()->after('total_harga');
            $table->decimal('uang_kembali', 10, 2)->nullable()->after('uang_bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['invoice', 'nama', 'no_hp', 'kapster_id', 'uang_bayar', 'uang_kembali']);
        });
    }
};
