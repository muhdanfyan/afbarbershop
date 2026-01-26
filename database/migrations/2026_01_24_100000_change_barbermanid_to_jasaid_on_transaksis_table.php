<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Drop old foreign key and column
            if (Schema::hasColumn('transaksis', 'barberman_id')) {
                $table->dropForeign(['barberman_id']);
                $table->dropColumn('barberman_id');
            }
            // Add jasa_id
            $table->unsignedBigInteger('jasa_id')->nullable()->after('barang_id');
            $table->foreign('jasa_id')->references('id')->on('jasa')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['jasa_id']);
            $table->dropColumn('jasa_id');
            $table->unsignedBigInteger('barberman_id')->nullable()->after('barang_id');
            $table->foreign('barberman_id')->references('id')->on('barberman')->onDelete('cascade');
        });
    }
};
