<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bengkels', function (Blueprint $table) {
            $table->id('id_bengkel');
            $table->string('nama_bengkel', 100);
            $table->text('alamat');
            $table->string('kota', 100);
            $table->string('nomor_telepon', 20);
            $table->string('email', 100)->nullable();
            $table->string('jenis_layanan', 100);
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bengkels');
    }
};
