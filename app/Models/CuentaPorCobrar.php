<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaPorCobrar extends Model
{
    use HasFactory;

    protected $table = 'cuentas_por_cobrar';

    protected $fillable = [
        'tipo',
        'descripcion',
        'pago_id',
        'monto',
        'estado',
        'venta_id'
    ];

    // Relación opcional con el modelo de Pago
    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
}
