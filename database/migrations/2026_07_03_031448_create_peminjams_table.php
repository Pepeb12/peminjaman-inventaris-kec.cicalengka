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
       Schema::create('peminjams', function (Blueprint $table) {
        $table->id('id_peminjam');
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
       $table->string('jenis_peminjam');
        $table->string('nama_instansi')->nullable();
        $table->string('kontak_penanggung_jawab');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjams');
    }
};
