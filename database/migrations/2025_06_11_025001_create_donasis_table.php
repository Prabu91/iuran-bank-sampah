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
        Schema::create('donasis', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('peserta_id')->constrained()->onDelete('cascade');
            $table->string('nama peserta');
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->decimal('jumlah_donasi', 12, 2);
            $table->string('bukti_tf');
            $table->date('tanggal');
            $table->enum('status', ['approve', 'menunggu approval', 'ditolak']);
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasis');
    }
};
