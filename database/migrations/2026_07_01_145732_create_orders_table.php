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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pl')->nullable();
            $table->string('no_meja')->nullable();
            $table->enum('status', ['menunggu_pembayaran', 'diproses', 'selesai'])->default('menunggu_pembayaran');
            $table->enum('metode_pembayaran', ['tunai', 'qris'])->nullable();
            $table->integer('dibayar')->nullable();
            $table->integer('kembalian')->nullable();
            $table->integer('total_harga')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
