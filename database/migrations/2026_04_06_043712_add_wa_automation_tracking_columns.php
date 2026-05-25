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
        Schema::table('transaksis', function (Blueprint $table) {
            $table->timestamp('review_requested_at')->nullable();
        });

        Schema::table('members', function (Blueprint $table) {
            $table->timestamp('reactivation_sent_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('review_requested_at');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('reactivation_sent_at');
        });
    }
};
