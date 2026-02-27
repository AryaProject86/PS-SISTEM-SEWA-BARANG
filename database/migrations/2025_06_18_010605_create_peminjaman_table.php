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
        Schema::create('peminjaman', function (Blueprint $table) {
           $table->id();
        $table->foreignId('pelanggan_id')->constrained()->onDelete('cascade');
        $table->foreignId('barang_id')->constrained()->onDelete('cascade');
        $table->date('tanggal_sewa');
        $table->date('tanggal_kembali')->nullable();
        $table->integer('harga_sewa')->nullable();
        $table->integer('total_biaya')->nullable();
        $table->enum('status', ['disewa', 'dikembalikan'])->default('disewa');
        $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
