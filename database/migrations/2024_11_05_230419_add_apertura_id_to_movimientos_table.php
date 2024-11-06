<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAperturaIdToMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimientos_caja', function (Blueprint $table) {
            // Agregar la columna apertura_id
            $table->unsignedBigInteger('apertura_id')->nullable()->after('usuario_id'); // Cambia 'usuario_id' por el campo adecuado

            // Establecer la clave foránea
            $table->foreign('apertura_id')->references('id')->on('aperturas_caja')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimientos_caja', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna
            $table->dropForeign(['apertura_id']);
            $table->dropColumn('apertura_id');
        });
    }
}
