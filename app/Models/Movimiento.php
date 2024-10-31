<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;
    protected $table = 'movimientos_caja';
    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }
    
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    

}
