<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // Relasi ke user (pembeli)
            $table->integer('total');
            $table->string('metode_pengiriman');
            $table->text('alamat')->nullable();
            $table->string('snap_token')->nullable(); // ✅ PENTING
            $table->string('status')->default('pending'); // ✅ Bisa bantu tracking
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
