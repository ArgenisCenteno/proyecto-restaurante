<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  /*  public function up(): void
    {
        Schema::table('pagos_cuentas', function (Blueprint $table) {
            $table->id(); // Llave primaria
            $table->foreignId('pago_id')->constrained('pagos')->onDelete('cascade'); // Referencia a pagos
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Referencia al usuario
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade'); // Referencia al cliente
            $table->decimal('monto', 15, 2); // Monto del pago
            $table->timestamps(); // created_at y updated_at
        });
    }
    
    /**
   //  * Reverse the migrations.
     */
  /*  public function down(): void
    {
        Schema::table('pagos_cuentas', function (Blueprint $table) {
            $table->dropColumn(['id', 'pago_id', 'user_id', 'cliente_id', 'monto']); // Eliminación de columnas
            $table->dropTimestamps(); // Eliminación de created_at y updated_at
        });
    }*/
    
};
