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
       Schema::create('peminjamans', function (Blueprint $table) {
        $table->string('id_peminjaman')->primary(); // PK untuk Format TRX (contoh: TRX-001)
        $table->foreignId('peminjam_id')->references('id_peminjam')->on('peminjams')->cascadeOnDelete();
        $table->date('tgl_pinjam');
        $table->date('tgl_kembali');
        $table->enum('status', ['Menunggu Proses', 'Dipinjam', 'Selesai', 'Ditolak'])->default('Menunggu Proses');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
