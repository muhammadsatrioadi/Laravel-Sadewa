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
            $table->id();
            $table->string('kd_barang')->unique();
            $table->string('gambar')->nullable();
            $table->string('nm_barang');
            $table->text('deskripsi');
            $table->date('tgl_penambahan')->nullable();
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('merk_id')->constrained('merks')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('lokasi_id')->constrained('lokasis')->cascadeOnUpdate()->restrictOnDelete();
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

