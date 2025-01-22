<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosCuentasPorCobrar extends Model
{
    use HasFactory;

    protected $table = 'pagos_cuentas_por_cobrar';

    protected $fillable = [
        'cuenta_por_cobrar_id',
        'pago_id',
        'monto_abono',
    ];

    /**
     * Relación con la tabla `cuentas_por_cobrar`.
     */
    public function cuentaPorCobrar()
    {
        return $this->belongsTo(CuentaPorCobrar::class);
    }

    /**
     * Relación con la tabla `pagos`.
     */
    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
}
