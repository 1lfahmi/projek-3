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
        Schema::create('pembelians', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->string('email');
    $table->string('no_telepon'); // 🔥 GANTI INI
    $table->string('kota');
    $table->text('alamat');
    $table->string('nama_mobil'); // 🔥 WAJIB ADA
    $table->timestamps();
});

}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
