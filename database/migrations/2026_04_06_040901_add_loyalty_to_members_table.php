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
        Schema::table('members', function (Blueprint $table) {
            $table->integer('poin')->default(0)->after('alamat');
            $table->integer('total_kunjungan')->default(0)->after('poin');
            $table->enum('level', ['Silver', 'Gold', 'Platinum'])->default('Silver')->after('total_kunjungan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['poin', 'total_kunjungan', 'level']);
        });
    }
};
