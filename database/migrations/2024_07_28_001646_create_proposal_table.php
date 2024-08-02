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
        Schema::create('proposal', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tgl_kegiatan');
            $table->string('surat_pengantar');
            $table->string('file_proposal');
            $table->string('lampiran_proposal');
            $table->enum('status_dosen', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->enum('status_dirmawa', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_dosen')->nullable();
            $table->unsignedBigInteger('id_dirmawa')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_dosen')->references('id')->on('dosen')->onDelete('set null');
            $table->foreign('id_dirmawa')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal');
    }
};
