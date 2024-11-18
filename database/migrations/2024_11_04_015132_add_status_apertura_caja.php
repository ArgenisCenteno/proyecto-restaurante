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
        Schema::table('aperturas_caja', function (Blueprint $table) {
            $table->string('estatus')->default('abierto'); // O puedes usar ENUM para estatus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aperturas_caja', function (Blueprint $table) {
            $table->dropColumn('estatus');
        });
    }
};
