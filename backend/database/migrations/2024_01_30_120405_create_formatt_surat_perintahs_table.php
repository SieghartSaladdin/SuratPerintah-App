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
        Schema::create('formatt_surat_perintahs', function (Blueprint $table) {
            $table->id();
            $table->string('gambar');
            $table->string('judul');
            $table->string('nama_lembaga');
            $table->string('website');
            $table->string('alamat');
            $table->string('kota_pos');
            $table->string('ditetapkan_di');
            $table->string('atas_nama');
            $table->string('an_nama');
            $table->string('an_jabatan');
            $table->string('an_nip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formatt_surat_perintahs');
    }
};
