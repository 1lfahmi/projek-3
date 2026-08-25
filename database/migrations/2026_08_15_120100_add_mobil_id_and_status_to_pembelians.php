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
        Schema::table('pembelians', function (Blueprint $table) {
            $table->unsignedBigInteger('mobil_id')->nullable()->after('nama_mobil');
            $table->string('status')->default('pending')->after('mobil_id'); // pending, completed, cancelled

            $table->foreign('mobil_id')->references('id')->on('mobils')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelians', function (Blueprint $table) {
            $table->dropForeign(['mobil_id']);
            $table->dropColumn(['mobil_id','status']);
        });
    }
};
