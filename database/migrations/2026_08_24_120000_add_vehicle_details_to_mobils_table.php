<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->string('mesin')->nullable()->after('merek');
            $table->string('transmisi')->nullable()->after('mesin');
            $table->string('bahan_bakar')->nullable()->after('transmisi');
            $table->unsignedInteger('cc')->nullable()->after('bahan_bakar');
            $table->string('warna')->nullable()->after('cc');
            $table->unsignedSmallInteger('tahun')->nullable()->after('warna');
            $table->string('penggerak')->nullable()->after('tahun');
        });
    }

    public function down(): void
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->dropColumn(['mesin', 'transmisi', 'bahan_bakar', 'cc', 'warna', 'tahun', 'penggerak']);
        });
    }
};
