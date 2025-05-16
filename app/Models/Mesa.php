<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero', // o nombre, según cómo identifiques las mesas
        'descripcion',
        'estado' // opcional: libre, ocupada, reservada, etc.
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

      public function ventaActiva()
{
    return $this->hasOne(Venta::class)->where('status', 'Pendiente'); // o 'abierta', según tu lógica
}
}
