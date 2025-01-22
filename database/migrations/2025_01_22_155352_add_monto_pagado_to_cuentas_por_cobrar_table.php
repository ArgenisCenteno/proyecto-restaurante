<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cuentas_por_cobrar', function (Blueprint $table) {
            $table->decimal('monto_pagado', 10, 2)->default(0)->after('monto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cuentas_por_cobrar', function (Blueprint $table) {
            $table->dropColumn('monto_pagado');
        });
    }
};
