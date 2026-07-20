<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('menunggu_pembayaran', 'diproses', 'selesai', 'kadaluwarsa') DEFAULT 'menunggu_pembayaran'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('menunggu_pembayaran', 'diproses', 'selesai') DEFAULT 'menunggu_pembayaran'");
        }
    }
};
