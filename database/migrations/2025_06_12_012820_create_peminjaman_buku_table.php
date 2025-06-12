<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peminjaman_buku', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peminjam');
            $table->string('nim')->nullable();
            $table->string('fakultas');
            $table->string('prodi');
            $table->string('judul_buku');
            $table->date('tanggal_pinjam');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_buku');
    }
};