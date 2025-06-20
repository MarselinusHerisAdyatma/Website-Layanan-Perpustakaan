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
        Schema::create('koleksi_perpustakaan', function (Blueprint $table) {
            $table->id();
            $table->integer('buku');
            $table->integer('jurnal');
            $table->integer('karya_ilmiah');
            $table->integer('anggota_aktif')->nullable();
            $table->integer('ebook_ejournal')->nullable();
            $table->integer('total_koleksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koleksi_perpustakaan');
    }
};
