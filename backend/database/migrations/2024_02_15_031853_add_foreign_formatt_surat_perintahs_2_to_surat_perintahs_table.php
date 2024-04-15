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
        Schema::table('surat_perintahs', function (Blueprint $table) {
            $table->unsignedBigInteger('formatt_surat_perintahs2_id')->nullable()->after('tanggal');
            $table->foreign('formatt_surat_perintahs2_id')->references('id')->on('formatt_surat_perintahs2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_perintahs', function (Blueprint $table) {
            $table->dropForeign(['formatt_surat_perintahs2_id']);
            $table->dropColumn('formatt_surat_perintahs2_id');
        });
    }
};
