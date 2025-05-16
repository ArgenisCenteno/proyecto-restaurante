<?php

namespace App\Http\Controllers;

use App\Models\CuentaPorCobrar;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;

class DetalleVentaController extends Controller
{
   public function destroy($id)
{
    $detalle = DetalleVenta::findOrFail($id);
    $venta = $detalle->venta;

    // Aumentar el inventario
    $producto = $detalle->producto;
    if ($producto) {
        $producto->cantidad += $detalle->cantidad;
        $producto->save();
    }

    // Eliminar el detalle
    $detalle->delete();

    // Recalcular total de la venta
    $venta->monto_total = $venta->detalleVentas()->sum(\DB::raw('neto + impuesto'));
    $venta->save();

    // Actualizar cuenta por cobrar
    $cuentaPorCobrar = CuentaPorCobrar::where('venta_id', $venta->id)->first();
    if ($cuentaPorCobrar) {
        $cuentaPorCobrar->monto = $venta->monto_total;
        $cuentaPorCobrar->save();
    }

    return redirect()->route('ventas.edit', $venta->id)->with('success', 'Producto eliminado de la venta.');
}


}
