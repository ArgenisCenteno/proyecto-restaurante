<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoCuentaPorPagar extends Model
{
    use HasFactory;

    protected $table = 'pago_cuenta_por_pagar';

    protected $fillable = [
        'proveedor_id',
        'user_id',
        'tipo',
        'descripcion',
        'pago_id',
        'monto',
        'estado',
        'monto_pagado',
        'compra_id'
    ];

    /**
     * Relación con el proveedor.
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Relación con el usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el pago.
     */
    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }

    /**
     * Relación con la compra.
     */
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
}
