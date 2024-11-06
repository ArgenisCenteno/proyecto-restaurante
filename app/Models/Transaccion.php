<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    use HasFactory;

    protected $table = 'transacciones';

    protected $fillable = [
        'caja_id',
        'usuario_id',
        'tipo',
        'monto_total_bolivares',
        'monto_total_dolares',
        'metodo_pago',
        'moneda',
        'fecha',
        'apertura_id'
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
