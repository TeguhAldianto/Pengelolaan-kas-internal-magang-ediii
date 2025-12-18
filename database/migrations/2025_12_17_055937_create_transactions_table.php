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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Siapa yang input
            $table->string('no_bukti')->unique();
            $table->enum('wallet_type', ['besar', 'kecil']); // Pembeda Kas
            $table->enum('type', ['in', 'out']); // Pemasukan / Pengeluaran
            $table->decimal('amount', 15, 2); // Pakai decimal untuk uang, bukan BigInt
            $table->text('description');
            $table->string('proof_image')->nullable(); // Path gambar bukti
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
