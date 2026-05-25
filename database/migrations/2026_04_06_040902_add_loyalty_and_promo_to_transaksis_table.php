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
            $table->unsignedBigInteger('member_id')->nullable()->after('status');
            $table->unsignedBigInteger('voucher_id')->nullable()->after('member_id');
            $table->integer('poin_earned')->default(0)->after('voucher_id');
            $table->integer('poin_used')->default(0)->after('poin_earned');
            $table->decimal('diskon_total', 15, 2)->default(0)->after('poin_used');

            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            $table->dropForeign(['voucher_id']);
            $table->dropColumn(['member_id', 'voucher_id', 'poin_earned', 'poin_used', 'diskon_total']);
        });
    }
};
