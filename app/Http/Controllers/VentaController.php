<?php

namespace App\Http\Controllers;

use App\Exports\VentasExport;
use App\Models\AperturaCaja;
use App\Models\Caja;
use App\Models\CuentaPorCobrar;
use App\Models\DetalleVenta;
use App\Models\Mesa;
use App\Models\Movimiento;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Recibo;
use App\Models\Tasa;
use App\Models\Transaccion;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Alert;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Venta::with(['user', 'vendedor', 'pago'])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('vendedor', function ($row) {
                    return $row->vendedor->name ?? 'S/D';
                })
                ->addColumn('monto_neto', function ($row) {
                    if ($row->pago) {
                        return number_format($row->pago->monto_neto, 2);
                    } else {
                        $status = $row->status;
                        $class = $status == 'Pagado' ? 'success' : 'danger'; // Clase basada en el estado
                        return '<span class="badge bg-' . $class . '">' . $status . '</span>';
                    }
                })
                ->addColumn('monto_total', function ($row) {
                    return number_format($row->monto_total, 2);
                })
                ->addColumn('fecha', function ($row) {
                    return $row->created_at->format('Y-m-d'); // Ajusta el formato de fecha aquí
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status;
                    $class = $status == 'Pagado' ? 'success' : 'danger'; // Clase basada en el estado
                    return '<span class="badge bg-' . $class . '">' . $status . '</span>';
                })
                ->addColumn('actions', function ($row) {
                    $viewUrl = route('ventas.show', $row->id);
                    $deleteUrl = route('ventas.destroy', $row->id);
                    $pdfUrl = route('ventas.pdf', $row->id); // Asegúrate de que la ruta esté correcta
                    return '<a href="' . $viewUrl . '" class="btn btn-info btn-sm">Ver</a>
                            <a href="' . $pdfUrl . '" class="btn btn-warning btn-sm" target="_blank">PDF</a>
                           <form action="' . $deleteUrl . '"  method="POST" style="display:inline; " class="btn-delete">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm " >Eliminar</button>
                        </form>';
                })
                ->rawColumns(['status', 'actions', 'monto_neto'])
                ->make(true);
        }

        return view('ventas.index');
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

    public function edit(string $id)
    {
        $venta = Venta::with('detalleVentas.producto', 'user', 'vendedor')->findOrFail($id);
        function isConnected()
        {
            $connected = @fsockopen("www.google.com", 80); // Intenta conectar al puerto 80 de Google
            if ($connected) {
                fclose($connected);
                return true; // Hay conexión
            }
            return false; // No hay conexión
        }

        if (isConnected()) {
            $response = file_get_contents("https://ve.dolarapi.com/v1/dolares/oficial");

        } else {

            $response = false;
        }



        // dd();
        if ($response) {
            $dato = json_decode($response);
            $dollar = $dato->promedio;
        } else {
            $dollar = 44.30;
        }
        return view('ventas.edit', compact('venta', 'dollar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $venta = Venta::findOrFail($id);
        $cantidades = $request->input('cantidades', []);
        $netos = $request->input('netos', []);

        $total = 0;

        // Actualizar productos existentes
        foreach ($cantidades as $detalleId => $nuevaCantidad) {
            $detalle = DetalleVenta::find($detalleId);

            if ($detalle && $detalle->id_venta == $venta->id) {
                $producto = Producto::find($detalle->id_producto);

                $cantidadAnterior = $detalle->cantidad;
                $diferencia = $nuevaCantidad - $cantidadAnterior;

                // Ajustar inventario según diferencia
                if ($diferencia > 0) {
                    if ($producto->cantidad >= $diferencia) {
                        $producto->cantidad -= $diferencia;
                    } else {
                        Alert::error('¡Sin Stock!', "No hay suficiente stock para el producto {$producto->nombre}")
                            ->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');


                        return back()->withErrors(['error' => "No hay suficiente stock para el producto {$producto->nombre}"]);
                    }
                } elseif ($diferencia < 0) {
                    $producto->cantidad += abs($diferencia);
                }
                $producto->save();

                //dd($netos[$detalleId]);


                if (isset($netos[$detalleId])) {
                    $neto = $detalle->precio_producto * $nuevaCantidad;

                }
                // Usar neto enviado desde el formulario, o calcular si no viene

                // Calcular impuesto basado en neto
                $impuesto = ($producto->aplica_iva == 1) ? $neto * 0.16 : 0;

                $detalle->cantidad = $nuevaCantidad;
                $detalle->neto = $neto ?? 0;
                $detalle->impuesto = $impuesto;
                $detalle->save();

                $total += $neto + $impuesto;
            }
        }

        // Manejar nuevos productos (igual que antes)
        if ($request->has('nuevos_productos')) {
            foreach ($request->nuevos_productos as $productoData) {
                $producto = Producto::find($productoData['producto_id']);
                $precio = $producto->precio_venta * $request->dollar;
                $cantidadNueva = $productoData['cantidad'];
                $neto = $precio * $cantidadNueva;
                //dd($producto->cantidad >= $cantidadNueva);
                if ($producto) {
                    if ($producto->cantidad >= $cantidadNueva) {
                        $producto->cantidad -= $cantidadNueva;
                        $producto->save();
                    } else {
                        Alert::error('¡Sin Stock!', "No hay suficiente stock para el producto {$producto->nombre}")
                            ->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');


                        return back()->withErrors(['error' => "No hay suficiente stock para el producto {$producto->nombre}"]);
                    }


                    $impuesto = $producto->aplica_iva == 1 ? $neto * 0.16 : 0;
                    //  dd($productoData);
                    DetalleVenta::create([
                        'id_venta' => $venta->id,
                        'id_producto' => $producto->id,
                        'precio_producto' => $precio,
                        'cantidad' => $cantidadNueva,
                        'neto' => $neto,
                        'impuesto' => $impuesto,
                    ]);

                    $total += $neto + $impuesto;
                }
            }
        }

        $venta->monto_total = $total;
        $venta->save();

        $cuentaPorCobrar = CuentaPorCobrar::where('venta_id', $venta->id)->first();
        if ($cuentaPorCobrar) {
            $cuentaPorCobrar->monto = $venta->monto_total;
            $cuentaPorCobrar->save();
        }

        return redirect()->route('ventas.edit', $venta->id)->with('success', 'Venta actualizada correctamente.');
    }


    public function vender(Request $request)
    {
        //$caja = Caja::where('activa', '1')->first();
        $users = User::pluck('name', 'id');
        $cajas = Caja::all();
        function isConnected()
        {
            $connected = @fsockopen("www.google.com", 80); // Intenta conectar al puerto 80 de Google
            if ($connected) {
                fclose($connected);
                return true; // Hay conexión
            }
            return false; // No hay conexión
        }

        if (isConnected()) {
            $response = file_get_contents("https://ve.dolarapi.com/v1/dolares/oficial");

        } else {

            $response = false;
        }



        // dd();
        if ($response) {
            $dato = json_decode($response);
            $dollar = $dato->promedio;
        } else {
            $dollar = 44.30;
        }

        $mesas = Mesa::where('estado', 'Disponible')->get();
        return view('ventas.vender')->with('mesas', $mesas)->with('cajas', $cajas)->with('dollar', $dollar)->with('users', $users);
    }

    public function datatableProductoVenta(Request $request)
    {
        if ($request->ajax()) {
            $productos = Producto::with('subCategoria', 'imagenes')->get(); // Cargar la relación subCategoria

            return DataTables::of($productos)
                ->addColumn('fecha_vencimiento', function ($producto) {
                    $date = Carbon::now();
                    if ($producto->fecha_vencimiento <= $date) {
                        return '<span class="badge bg-danger">Vencido</span>';
                    } else {
                        return $producto->fecha_vencimiento;
                    }
                })
                ->editColumn('created_at', function ($producto) {
                    return $producto->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('subCategoria', function ($producto) {
                    return $producto->subCategoria ? $producto->subCategoria->nombre : '';
                })
                ->addColumn('actions', function ($producto) {
                    return '<button type="button" id="agregarCarrito" class="btn btn-info"><span class="material-icons">shopping_cart</span></button>';
                })
                ->rawColumns(['fecha_vencimiento', 'actions']) // Especifica las columnas que contienen HTML sin escape
                ->make(true);
        }
    }


    public function obtenerProducto(Request $request, $id)
    {
        if ($request->ajax()) {
            $producto = Producto::with('subCategoria', 'imagenes')->find($id);


            if (!$producto) {
                return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
            }

            return response()->json(['success' => true, 'producto' => $producto]);
        } else {
            return response()->json(['success' => false, 'message' => 'Solicitud no válida'], 400);
        }
    }

    public function generarVenta(Request $request)
    {
        // dd("test");
        $caja = Caja::find(1);
        $clienteId = 1;
        if ($request->cedula && $request->email && $request->name) {
            $consulta = User::where('email', $request->email)->first();
            if ($consulta) {
                Alert::error('¡Error!', 'Este email se encuentra registrado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                return redirect()->back();
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->cedula), // Encriptar la contraseña
                'dni' => $request->cedula,
                'status' => 'Activo',
            ]);

            // Asignar el rol al usuario
            $user->assignRole($request->role);

            $clienteId = $user->id;
        } else {
            $clienteId = $request->user_id;
        }

        if (!$caja) {
            Alert::error('¡Error!', 'No hay caja disponible')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();
        }

        $apertura = AperturaCaja::where('caja_id', $caja->id)->where('estado', 'Operando')->first();
        if (!$apertura) {
            Alert::error('¡Error!', 'No existe una caja abierta')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();
        }

        if ($request->productos == [] || $request->productos == null) {
            Alert::error('¡Error!', 'Para realizar una venta es necesario agregar productos')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();
        }

        // Obtener datos
        $productos = json_decode($request->productos, true);
        $metodos = json_decode($request->metodos_pago, true);

        // Verificar si existe un método de pago "A crédito"
        $metodoCredito = collect($metodos)->firstWhere('metodo', 'A credito');

        // Calcular el monto total y neto
        $totalNeto = 0;
        $montoTotal = 0;
        $impuestosTotal = 0;

        foreach ($productos as $producto) {
            $productoModel = Producto::find($producto['id']);
            if ($productoModel->cantidad < $producto['cantidad']) {
                $nombreProducto = $productoModel->nombre;
                Alert::error('¡Error!', "Stock insuficiente para el producto: $nombreProducto")
                    ->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                return redirect()->back();
            }

            $totalNeto += $producto['precio'] * $producto['cantidad'];

            if ($producto['aplicaIva'] == 1) {
                $montoTotal += $producto['cantidad'] * $producto['precio'] * 1.16;
                $impuestosTotal += ($producto['precio'] * 0.16) * $producto['cantidad'];
            } else {
                $montoTotal += $producto['precio'] * $producto['cantidad'];
            }
        }

        $userId = Auth::id();

        // Si el método es "A crédito", generar la CuentaPorCobrar y guardar la venta como "Pendiente"
        if ($metodoCredito) {
            $venta = new Venta();
            $venta->user_id = $clienteId;
            $venta->vendedor_id = $userId;
            $venta->monto_total = $montoTotal;
            $venta->status = 'Pendiente'; // Venta pendiente
            $venta->tipo = 'Crédito'; // Venta pendiente
            if ($request->mesa_id) {
                $mesa = Mesa::find($request->mesa_id);
                $mesa->estado = 'Ocupada';
                $mesa->save();

                $venta->mesa_id = $request->mesa_id;
            }

            $venta->save();

            $cuentaPorCobrar = new CuentaPorCobrar();
            $cuentaPorCobrar->tipo = 'A crédito';
            $cuentaPorCobrar->descripcion = 'Venta a crédito';
            $cuentaPorCobrar->venta_id = $venta->id;
            $cuentaPorCobrar->monto = $montoTotal;
            $cuentaPorCobrar->estado = 'Pendiente';
            $cuentaPorCobrar->save();

            // Registrar detalles de la venta
            foreach ($productos as $producto) {
                $detalleVenta = new DetalleVenta();
                $detalleVenta->id_producto = $producto['id'];
                $detalleVenta->precio_producto = $producto['precio'];
                $detalleVenta->cantidad = $producto['cantidad'];
                $detalleVenta->neto = $producto['precio'] * $producto['cantidad'];
                $detalleVenta->impuesto = ($producto['aplicaIva'] == 1) ? ($producto['precio'] * 0.16) * $producto['cantidad'] : 0;
                $detalleVenta->id_venta = $venta->id;
                $detalleVenta->save();

                // Actualizar stock
                $productoModel = Producto::find($producto['id']);
                if ($productoModel) {
                    $productoModel->cantidad -= $producto['cantidad'];
                    $productoModel->save();
                }
            }

            Alert::success('¡Éxito!', 'Venta a crédito generada exitosamente')
                ->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();
        } else {

            $pago = new Pago();
            $pago->status = 'Pagado';
            $pago->tipo = 'Venta Regular';
            $pago->forma_pago = json_encode($metodos);
            $pago->monto_total = $montoTotal;
            $pago->monto_neto = $totalNeto;
            $pago->tasa_dolar = $request->tasa;
            $pago->creado_id = $userId;
            $pago->fecha_pago = Carbon::now()->format('Y-m-d');
            $pago->impuestos = $impuestosTotal;
            $pago->save();

            $venta = new Venta();
            $venta->user_id = $clienteId;
            $venta->pago_id = $pago->id;
            $venta->vendedor_id = $userId;
            $venta->monto_total = $montoTotal;
            if ($request->mesa_id) {
                $mesa = Mesa::find($request->mesa_id);
                $mesa->estado = 'Ocupada';
                $mesa->save();

                $venta->mesa_id = $request->mesa_id;
            }
            $venta->status = 'Pagado'; // Venta pendiente
            $venta->save();

            foreach ($productos as $producto) {
                $detalleVenta = new DetalleVenta();
                $detalleVenta->id_producto = $producto['id'];
                $detalleVenta->precio_producto = $producto['precio'];
                $detalleVenta->cantidad = $producto['cantidad'];
                $detalleVenta->neto = $producto['precio'] * $producto['cantidad'];
                $detalleVenta->impuesto = ($producto['aplicaIva'] == 1) ? ($producto['precio'] * 0.16) * $producto['cantidad'] : 0;
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
            $recibo->tipo = 'Venta';
            $recibo->monto = $montoTotal;
            $recibo->estatus = 'Pagado';
            $recibo->pago_id = $pago->id;
            $recibo->user_id = $clienteId;
            $recibo->activo = 1;
            $recibo->creado_id = $userId;
            $recibo->descuento = $request->descuento;
            $recibo->save();

            //caja

            foreach ($metodos as $metodo) {
                $transaccion = new Transaccion();
                $transaccion->caja_id = 1;
                $transaccion->usuario_id = $userId;
                $transaccion->tipo = 'VENTA';
                $transaccion->apertura_id = $apertura->id;
                $transaccion->venta_id = $venta->id;
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
            }
        }

        Alert::success('¡Exito!', 'Venta generada exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('ventas.index');
    }


    public function destroy($id)
    {
        // Encuentra la venta por su ID
        $venta = Venta::find($id);

        if (!$venta) {
            Alert::error('¡Error!', 'Venta no encontrada')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->route('ventas');
        }

        // Elimina los detalles de la venta
        $venta->detalleVentas()->delete();

        // Elimina el pago asociado a la venta
        if ($venta->pago) {
            $venta->pago->delete();
        }

        $cuentas = CuentaPorCobrar::where('venta_id', $venta->id)->get();
        foreach ($cuentas as $cuenta) {
            $cuenta->delete();
        }

        // Elimina la venta
        $venta->delete();

        Alert::success('¡Éxito!', 'Venta y pago eliminados exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('ventas.index');
    }


    public function show($id)
    {
        $venta = Venta::with(['user', 'vendedor', 'pago', 'detalleVentas'])->find($id);
        return view('ventas.show', compact('venta'));
    }

    public function export(Request $request)
    {
        //   dd("test");
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        return Excel::download(new VentasExport($start_date, $end_date), 'ventas_' . $start_date . '_to_' . $end_date . '.xlsx');
    }
}
