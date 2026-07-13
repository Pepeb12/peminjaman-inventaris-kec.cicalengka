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
        Schema::create('barangs', function (Blueprint $table) {
            $table->string('kode_barang')->primary(); // PK bertipe String
            $table->string('nama_barang');
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->integer('stok_total');
            $table->integer('stok_tersedia');
            $table->string('kondisi');
            $table->string('foto_barang')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};