<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToAperturasCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aperturas_caja', function (Blueprint $table) {
            $table->string('estado')->default('Operando'); // Cambia 'ultimo_campo' por el último campo de tu tabla
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aperturas_caja', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
}
