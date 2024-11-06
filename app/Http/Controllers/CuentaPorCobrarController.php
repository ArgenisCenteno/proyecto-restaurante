<?php
namespace App\Http\Controllers;

use App\Models\AperturaCaja;
use App\Models\Caja;
use App\Models\CuentaPorCobrar;
use App\Models\Movimiento;
use App\Models\Pago;
use App\Models\Recibo;
use App\Models\Transaccion;
use App\Models\Venta;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Alert;
use Yajra\DataTables\DataTables;

class CuentaPorCobrarController extends Controller
{
    // Método para listar todas las cuentas por cobrar


    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Obtener los datos de la tabla Cuentas por Cobrar con las relaciones necesarias
            $data = CuentaPorCobrar::with('pago')->orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addIndexColumn()

                // Columna para mostrar el tipo de cuenta por cobrar
                ->addColumn('tipo', function ($row) {
                    return $row->tipo;
                })

                // Columna para la descripción
                ->addColumn('descripcion', function ($row) {
                    return $row->descripcion;
                })

                // Columna para el monto con formato
                ->addColumn('monto', function ($row) {
                    return number_format($row->monto, 2);
                })

                // Columna para la fecha de creación formateada
                ->addColumn('fecha', function ($row) {
                    return $row->created_at->format('Y-m-d');
                })

                // Columna para el pago_id, si es nulo muestra "Sin pagar"
                ->addColumn('pago_id', function ($row) {
                    return $row->pago_id ? $row->pago_id : 'Sin pagar';
                })

                // Columna para mostrar el estado con una etiqueta (badge)
                ->addColumn('estado', function ($row) {
                    $estado = $row->estado;
                    $class = $estado == 'Pagado' ? 'success' : 'danger'; // Clase según estado
                    return '<span class="badge bg-' . $class . '">' . $estado . '</span>';
                })

                // Columna de acciones (editar, eliminar, ver PDF)
                ->addColumn('actions', function ($row) {
                    $editUrl = route('cuentas-por-cobrar.show', $row->id);
                    $deleteUrl = route('cuentas-por-cobrar.destroy', $row->id);
                  
    
                    return '
                        <a href="' . $editUrl . '" class="btn btn-primary btn-sm">Editar</a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline;" class="btn-delete">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>';
                })

                // Hacer que ciertas columnas contengan HTML
                ->rawColumns(['estado', 'actions'])
                ->make(true);
        } else {
            // Retorna la vista si no es una petición Ajax
            return view('cuentas-por-cobrar.index');
        }


    }


    // Método para crear una nueva cuenta por cobrar
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string',
            'descripcion' => 'required|string',
            'monto' => 'required|numeric',
            'estado' => 'required|string',
        ]);

        $cuenta = CuentaPorCobrar::create($request->all());
        return response()->json($cuenta, 201);
    }

    // Método para mostrar una cuenta específica
    public function show($id)
    {
        $cuenta = CuentaPorCobrar::findOrFail($id);
        $cajas = Caja::all();
        return view('cuentas-por-cobrar.show', compact('cuenta', 'cajas'));
    }

    // Método para actualizar una cuenta por cobrar
    public function update(Request $request, $id)
    {
        $cuenta = CuentaPorCobrar::findOrFail($id);
        if (!$request->caja) {
            Alert::error('¡Error!', 'Debe seleccionar una caja')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();
        }
        $caja = Caja::find($request->caja);
        $apertura = AperturaCaja::where('caja_id', $caja->id)->where('estado', 'Operando')->first();
        if (!$apertura) {
            Alert::error('¡Error!', 'La caja seleccionada no está abierta')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();
        }
        if($cuenta->pago_id != null){
            Alert::error('¡Error!', 'Esta cuenta ya fue pagada')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

            return redirect()->back();
        }

        $pago = new Pago();
        $pago->tipo = 'Venta';
        $pago->status = 'Pagado';
        $pago->monto_total = $request->monto_pago;
        $pago->monto_neto = $request->monto_pago;
        $pago->forma_pago = $request->tipo_pago;
        $pago->creado_id = Auth::user()->id;
        $cuenta->estado = 'Pagado';
        $pago->fecha_pago = Carbon::now();
        $pago->save();

        $cuenta->estado = 'Pagado';
        $cuenta->pago_id = $pago->id;
        $cuenta->save();

        $recibo = new Recibo();
        $recibo->tipo = 'Venta';
        $recibo->monto = $request->monto_pago;
        $recibo->estatus = $pago->status;
        $recibo->pago_id = $pago->id;
        $recibo->user_id = $request->user_id;
        $recibo->activo = 1;
        $recibo->creado_id = Auth::user()->id;
        $recibo->descuento = $request->descuento;
        $recibo->save();

        //caja
       
        $movimiento = new Movimiento();

        $movimiento->caja_id = $caja->id; 
        $movimiento->usuario_id = Auth::user()->id; 
        $movimiento->tipo = 'entrada'; 
        $movimiento->descripcion = "Registro de venta"; 
        $movimiento->fecha = now(); 
        $movimiento->apertura_id = $apertura->id;


        
        // Verificar la forma de pago y asignar el monto correspondiente
        if ($request->forma_pago === 'Divisa') {
            $movimiento->monto_dolares =  $request->monto_pago; // Asignar el monto total en dólares
            $movimiento->monto_bolivares = 0; // Asegúrate de que el campo en bolívares esté vacío
        } else {
            $movimiento->monto_bolivares = $request->monto_pago; // Asignar el monto total en bolívares
            $movimiento->monto_dolares = 0; // Asegúrate de que el campo en dólares esté vacío
        }
        
        // Guardar el movimiento en la base de datos
        $movimiento->save();

        //Transaccion

        $transaccion = new Transaccion();
        $transaccion->caja_id = $caja->id;
        $transaccion->usuario_id = Auth::user()->id;
        $transaccion->monto_total_bolivares =  $request->monto_pago;
        $transaccion->monto_total_dolares =  0;
        $transaccion->metodo_pago =  $request->tipo_pago;
        $transaccion->moneda =  'Bolivar';
        $transaccion->fecha =  Carbon::now();
        $transaccion->apertura_id = $apertura->id;

        $transaccion->save();

        $venta = Venta::find($cuenta->venta_id);
        $venta->status = 'Pagado';
        $venta->pago_id = $pago->id;
        $venta->save();

        Alert::success('¡Exito!', 'Cuenta por cobrar actualizada correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('cuentas-por-cobrar.index');

    }

    // Método para eliminar una cuenta por cobrar
    public function destroy($id)
    {
        $cuenta = CuentaPorCobrar::findOrFail($id);
        $cuenta->delete();
        return response()->json(null, 204);
    }
}
