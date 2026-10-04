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
        Schema::create('detail_peminjamans', function (Blueprint $table) {
        $table->id('id_detail_peminjaman');
        // Foreign key ke peminjamans (tipe string)
        $table->string('peminjaman_id');
        $table->foreign('peminjaman_id')->references('id_peminjaman')->on('peminjamans')->cascadeOnDelete();
        
        // Foreign key ke barangs (tipe string)
        $table->string('kode_barang');
        $table->foreign('kode_barang')->references('kode_barang')->on('barangs')->cascadeOnDelete();
        
        $table->integer('jumlah');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjamans');
    }
};
