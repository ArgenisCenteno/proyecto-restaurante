<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoCuenta extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'pagos_cuentas';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'pago_id',
        'user_id',
        'cliente_id',
        'monto',
    ];

    /**
     * Relación con el modelo Pago.
     * Un registro de pagos_cuentas pertenece a un pago.
     */
    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }

    /**
     * Relación con el modelo User para el usuario responsable.
     * Un registro de pagos_cuentas pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el modelo User para el cliente.
     * Un registro de pagos_cuentas pertenece a un cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
