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
    Schema::create('mobils', function (Blueprint $table) {
        $table->id();
        $table->string('seri');
        $table->string('nama_mobil'); // Pastikan baris ini ada dan tulisannya benar
        $table->string('merek');
        $table->integer('harga');
        $table->integer('stok');
        $table->string('foto')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
