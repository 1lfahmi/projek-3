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
    Schema::create('beli', function (Blueprint $table) {
        $table->id(); // Ini otomatis jadi Primary Key dan Auto Increment
        $table->string('nama');
        $table->string('email');
        $table->string('no_telepon');
        $table->text('alamat'); // Gunakan text karena alamat bisa panjang
        $table->string('kota');
        $table->timestamps(); // Ini akan membuat kolom created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beli');
    }
};
