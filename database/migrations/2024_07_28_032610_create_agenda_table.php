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
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->string('nama_agenda');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable();
            $table->string('tempat');
            $table->time('jam_mulai');
            $table->time('jam_selesai')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda');
    }
};
