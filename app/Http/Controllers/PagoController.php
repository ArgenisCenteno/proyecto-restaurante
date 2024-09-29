<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Recibo;
use App\Models\Tasa;
use App\Models\Transaccion;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Alert;
use Illuminate\Support\Facades\Auth;
use App\Notifications\VentaGenerada;
use Spatie\Permission\Models\Role;
class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pago::with(['user', 'compras', 'ventas'])->get();


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })

                ->addColumn('monto_total', function ($row) {
                    return number_format($row->monto_total, 2);
                })
                ->addColumn('fecha', function ($row) {
                    return $row->created_at->format('Y-m-d'); // Ajusta el formato de fecha aquí
                })
                ->addColumn('tipo', function ($row) {
                    return $row->tipo; // Ajusta el formato de fecha aquí
                })

                ->addColumn('status', function ($row) {
                    $status = $row->status;
                    $class = $status == 'Pagado' ? 'success' : 'danger'; // Clase basada en el estado
                    return '<span class="badge bg-' . $class . '">' . $status . '</span>';
                })

                ->addColumn('actions', function ($row) {
                    $viewUrl = route('pagos.edit', $row->id);
                    $deleteUrl = route('pagos.destroy', $row->id);
                    $pdfUrl = route('pagos.pdf', $row->id); // Asegúrate de que la ruta esté correcta
                    return '
                           <form action="' . $deleteUrl . '"  method="POST" style="display:inline; " class="btn-delete">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm " >Eliminar</button>
                        </form>';
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('pagos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //dd("test");
        $pago = Pago::findOrFail($id); // Get the payment record by ID
        return view('pagos.edit', compact('pago')); // Return the edit view with the payment record
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $pago = Pago::findOrFail($id); // Find the payment by ID
        $pago->status = $request->status; // Update the status
        $pago->save(); // Save the changes

        $venta = Venta::where('pago_id', $id)->first();
        $recibo = Recibo::where('pago_id', $id)->first();

        if (($request->status == 'Pagado' || $request->status == 'Rechazado') && $pago->tipo == 'Venta Online') {
            $venta->status = $request->status;
            $venta->save();

            $recibo->estatus = $request->status;
            $recibo->save();
        }

        Alert::success('¡Exito!', 'Pago actualizado exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('pagos.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pago = Pago::findOrFail($id); // Find the payment by ID
        $pago->detele();
        Alert::success('¡Exito!', 'Pago eliminado exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('pagos.index'));
    }

    public function pagarCuenta(Request $request)
    {
        $carrito = session()->get('cart');

        if (!$carrito) {
            Alert::error('¡Error!', 'Carrito vacío')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();
        }

        $total = 0;
        $impuesto = 0;
        $montoTotal = 0;



        if (count($carrito) > 0) {
            foreach ($carrito as $c) {
                $total += $c['precio'] * $c['cantidad'];

                $consulta = Producto::find($c['id']);
                //dd($consulta);
                if ($consulta->aplica_iva === 1) {
                    $impuesto += $c['precio'] * $c['cantidad'] * 0.16;
                }

            }
        }

        $montoTotal = $impuesto + $total;

        if ($request->hasFile('comprobante')) {
            $comprobante = $request->file('comprobante');

            $nombreComprobante = time() . '_' . $comprobante->getClientOriginalName();


            $rutaComprobante = '/files/pagos/' . $nombreComprobante;


            $comprobante->move(public_path('files/pagos'), $nombreComprobante);

        }

        $userId = Auth::id();

        // Obtener los datos del formulario
        $bancoOrigen = $request->input('banco_origen');
        $bancoDestino = $request->input('banco_destino');
        $numeroReferencia = $request->input('numero_referencia');
        $metodo = $request->input('metodo');
        $montoDollar = 0; // Ejemplo de monto en dólares basado en la tasa de cambio

        $dollar = Tasa::where('name', 'Dollar')->where('status', 'Activo')->first();

        // Crear el array con el método de pago
        $metodos = [
            [
                "metodo" => strtoupper($metodo),
                "cantidad" => $montoTotal,
                "banco_origen" => strtoupper($bancoOrigen), // Para asegurarte de que los bancos estén en mayúsculas
                "banco_destino" => strtoupper($bancoDestino),
                "numero_referencia" => $numeroReferencia,
                "monto_bs" => $montoTotal,
                "monto_dollar" => $montoDollar,
            ]
        ];

        if ($montoTotal != $request->input('montoTotal')) {
            Alert::error('¡Error!', 'El monto pagado es menor al monto total a pagar segun nuestros datos.')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        }

        //registrar pago

        $pago = new Pago();
        $pago->status = 'Pendiente';
        $pago->tipo = 'Venta Online';
        $pago->forma_pago = json_encode($metodos);
        $pago->monto_total = $montoTotal;
        $pago->monto_neto = $total;
        $pago->tasa_dolar = $dollar->valor ?? 0;
        $pago->creado_id = $userId;
        $pago->fecha_pago = Carbon::now()->format('Y-m-d');
        $pago->impuestos = $impuesto;
        $pago->save();

        //registrar venta
        $venta = new Venta();
        $venta->user_id = $userId;
        //  $venta->vendedor_id = $userId;
        $venta->monto_total = $montoTotal;
        $venta->status = 'Pendiente';
        $venta->pago_id = $pago->id;
        $venta->save();

        // Registrar detalles ventas
        foreach ($carrito as $producto) {



            $detalleVenta = new DetalleVenta();
            $detalleVenta->id_producto = $producto['id'];
            $detalleVenta->precio_producto = $producto['precio'];
            $detalleVenta->cantidad = $producto['cantidad'];
            $detalleVenta->neto = $producto['precio'] * $producto['cantidad'];

            $consulta = Producto::find($c['id']);
            //dd($consulta);
            if ($consulta->aplica_iva === 1) {
                $detalleVenta->impuesto = $c['precio'] * $c['cantidad'] * 0.16;
            } else {
                $detalleVenta->impuesto = 0;
            }
            $detalleVenta->id_venta = $venta->id;
            $detalleVenta->save();

            // Actualizar stock
            $productoModel = Producto::find($producto['id']);
            if ($productoModel) {
                $productoModel->cantidad -= $producto['cantidad'];
                $productoModel->save();
            }
        }

        $recibo = new Recibo();
        $recibo->tipo = 'Venta Online';
        $recibo->monto = $montoTotal;
        $recibo->estatus = 'Pendiente';
        $recibo->pago_id = $pago->id;
        $recibo->user_id = $userId;
        $recibo->activo = 1;
        // $recibo->creado_id = $userId;
        $recibo->descuento = $request->descuento;
        $recibo->save();

        //caja

        /*    foreach ($metodos as $metodo) {
                $transaccion = new Transaccion();
                $transaccion->caja_id = $request->id_caja;
                $transaccion->usuario_id = $userId;
                $transaccion->tipo = 'venta';
                $transaccion->metodo_pago = $metodo['metodo'];
                if ($metodo['metodo'] == 'Divisa') {
                    $transaccion->moneda = 'Dollar';
                    $transaccion->monto_total_dolares = $metodo['monto_dollar'] ?? 0;
                    $transaccion->monto_total_bolivares = 0;
                } else {
                    $transaccion->moneda = 'Bolívar';
                    $transaccion->monto_total_bolivares = $metodo['monto_bs'] ?? 0;
                    $transaccion->monto_total_dolares = 0;
                }
                $transaccion->fecha = Carbon::now();
                $transaccion->save();
            } */

        session()->forget('cart');
        $administradores = User::role('superAdmin')->get();

        foreach ($administradores as $admin) {
            try {
                $admin->notify(new VentaGenerada($venta));
            } catch (\Exception $e) {
                // Maneja el error, por ejemplo, registrando el error o mostrando un mensaje
                \Log::error('Error al enviar notificación: ' . $e->getMessage());
            }
        }
        
        Alert::success('Exito!', 'Orden generada correctamente, espere que su compra sea procesada')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect(route('pagos.index'));
    }
}
