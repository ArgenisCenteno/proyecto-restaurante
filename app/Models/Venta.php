<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendedor_id',
        'monto_total',
        'status',
        'porcentaje_descuento',
        'pago_id',
        'mesa',
        'tipo'
    ];

    public function pago()
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }
    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }
    public function cuenta()
{
    return $this->hasOne(CuentaPorCobrar::class, 'venta_id');
}


}
