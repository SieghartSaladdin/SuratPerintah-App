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
        Schema::create('surat_perintah_untuk2s', function (Blueprint $table) {
            $table->id();
            $table->string('untuk');
            $table->string('biayaperjalanan');
            $table->string('lamaperjalanan');
            $table->unsignedBigInteger('surat_perintah_id');
            $table->foreign('surat_perintah_id')->references('id')->on('surat_perintahs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_perintah_untuk2s');
    }
};
