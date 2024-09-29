<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleVenta;
use App\Models\Pago;
use App\Models\Venta;
use Illuminate\Http\Request;
use Alert;
use Carbon;
use PDF;
class PdfController extends Controller
{
    public function pdfVenta(Request $request, $id)
    {
        $venta = Venta::with('detalleVentas', 'vendedor', 'user', 'pago')->where('id', $id)->first();

        if (!$venta) {
            Alert::error('¡Error!', 'Venta no encontrada.')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('ventas.index'));
        }
        // Ocultar 'password' y 'remember_token' y convertir a array
        $vendedorArray = $venta->vendedor->makeHidden(['password', 'remember_token'])->toArray();
        $userArray = $venta->user->makeHidden(['password', 'remember_token'])->toArray();
        $fechaVenta = $venta->created_at->format('d-m-Y');
        $formaPagoArray = json_decode($venta->pago->forma_pago, true); 


       // dd($vendedorArray);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('ventas.pdf', compact('venta', 'formaPagoArray', 'vendedorArray', 'userArray', 'fechaVenta'));
        return $pdf->stream('venta.pdf');
    }

    public function pdfCompra(Request $request, $id)
    {
        $compra = Compra::with('detalleCompras', 'user', 'proveedor', 'pago')->where('id', $id)->first();

        if (!$compra) {
            Alert::error('¡Error!', 'Venta no encontrada.')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('ventas.index'));
        }
        // Ocultar 'password' y 'remember_token' y convertir a array
        $vendedorArray = $compra->user->makeHidden(['password', 'remember_token'])->toArray();
      
        $fechacompra = $compra->created_at->format('d-m-Y');
        $formaPagoArray = json_decode($compra->pago->forma_pago, true); 


       // dd($vendedorArray);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('compras.pdf', compact('compra', 'formaPagoArray', 'vendedorArray',  'fechacompra'));
        return $pdf->stream('venta.pdf');
    }

    public function pdfPago(Request $request, $id)
    {
        $pago = Pago::with('ventas', 'user', 'compras')->where('id', $id)->first();

        

        if (!$pago) {
            Alert::error('¡Error!', 'Venta no encontrada.')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('ventas.index'));
        }

        if($pago->tipo == 'Venta Regular'){
            $detalles = $pago->compras;
        }else{
            $detalles = $pago->detalles;
        }

        // Ocultar 'password' y 'remember_token' y convertir a array
        $userArray = $pago->user->makeHidden(['password', 'remember_token'])->toArray();
      
        $fechapago = $pago->created_at->format('d-m-Y');
        $formaPagoArray = json_decode($pago->forma_pago, true); 


       // dd($vendedorArray);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('pagos.pdf', compact('pago', 'formaPagoArray', 'userArray', 'detalles' , 'fechapago'));
        return $pdf->stream('venta.pdf');
    }

    public function pdfEstadoCuenta($id){
        //
    }

}
