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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // masyarakat
            $table->foreignId('unit_id')->constrained('unit_layanans')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_pengaduans')->onDelete('cascade');
            $table->string('judul');
            $table->text('isi_laporan');
            $table->string('lokasi')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('status')->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
