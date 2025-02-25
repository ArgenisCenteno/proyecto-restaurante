<?php

namespace App\Http\Controllers;

use App\Models\AperturaCaja;
use App\Models\Caja;
use App\Models\CierreCaja;
use App\Models\Movimiento;
use App\Models\Transaccion;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Flash;
use Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $caja = Caja::all();

            return DataTables::of($caja)
                ->addColumn('status', function ($categoria) {
                    if ($categoria->activa == 0) {
                        return '<span class="badge bg-danger">Inactivo</span>';
                    } elseif ($categoria->activa == 1) {
                        return '<span class="badge bg-success">Activo</span>';
                    } else {
                        return '';
                    }
                })

                ->addColumn('actions', 'caja.actions')
                ->rawColumns(['status', 'actions'])
                ->make(true);
        } else {
            return view('caja.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('caja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $consultar = Caja::where('nombre', $request->nombre)->first();



        if ($consultar) {
            Alert::error('¡Error!', 'Existe una caja con este nombre')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        $crear = Caja::create([
            'nombre' => $request->nombre,
            'activa' => $request->status
        ]);
        if ($crear) {
            // Categoría creada correctamente
            Alert::success('¡Éxito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        } else {
            // Error al intentar crear la categoría
            Alert::error('¡Error!', 'Error al intentar registrar la caja')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        }

        return redirect(route('cajas.index'));
    }

    /**
     * Display the specified resource.
     */
    public function aperturarCaja(string $id)
    {
        $caja = Caja::where('id', $id)->where('activa', 1)->first();


        if (!$caja) {
            Alert::error('¡Error!', 'No se puede abrir una caja inactiva')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('cajas.index'));
        }
        $apertura = AperturaCaja::where('caja_id', $caja->id)
         
        ->orderBy('id', 'desc') // Ordena de manera descendente
        ->first();

        //dd($apertura);
        if ($apertura) {
          //  dd($apertura);
            if ($apertura->estado == 'Operando') {
                $movimientos = Movimiento::where('apertura_id', $apertura->id)->get();
                $transacciones = Transaccion::where('apertura_id', $apertura->id)->get();
                
                return view('caja.cierre')->with('caja', $caja)->with('movimientos', $movimientos)->with('transacciones', $transacciones);
            }
        }


        return view('caja.abrirCaja')->with('caja', $caja);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $caja = Caja::findOrFail($id);

        return view('caja.edit')->with('caja', $caja);
    }

    /**  
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $actualizar = Caja::where('id', $id)->first();


        if (!$actualizar) {
            Alert::error('¡Error!', 'No existe esta caja')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        $actualizar->update([
            'nombre' => $request->nombre,
            'status' => $request->status
        ]);
        if ($actualizar) {
            // Categoría creada correctamente
            Alert::success('¡Éxito!', 'Registro actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        } else {
            // Error al intentar crear la categoría
            Alert::error('¡Error!', 'Error al intentar actualizar la caja')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        }

        return redirect(route('cajas.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $caja = Caja::where('id', $id)->first();


        if (!$caja) {
            Alert::error('¡Error!', 'No existe esta caja')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        $caja->delete();
        Alert::success('¡Éxito!', 'Caja eliminada exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('cajas.index');
    }

    public function registrarApertura(Request $request, $id)
    {



        // Crear el registro de apertura de caja
        $aperturaCaja = AperturaCaja::create([
            'caja_id' => $id,
            'usuario_id' => Auth::id(), // Asigna el ID del usuario autenticado
            'monto_inicial_bolivares' => $request->input('monto_inicial_bolivares'),
            'monto_inicial_dolares' => $request->input('monto_inicial_dolares'),
            'apertura' => now(), // Asigna la fecha y hora actuales
        ]);

        // Devolver una respuesta
        Alert::success('¡Éxito!', 'Caja aperturada exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('cajas.index');
    }

    public function cerrarCaja(Request $request, $id)
    {
        $caja = Caja::find($id);
        $apertura = AperturaCaja::where('caja_id', $caja->id)->where('estado', 'Operando')->first();

      
        $transacciones = Transaccion::where('apertura_id', $id)
            ->where('caja_id', $apertura->caja_id)

            ->get();

        // Calcular los totales generales

        $montoBs = 0;
        $montoDolar = 0;


        foreach ($transacciones as $transaccion) {

            $montoBs += $transaccion->monto_total_bolivares;
            $montoDolar += $transaccion->monto_total_dolares;

        }


        // Aquí puedes crear una nueva instancia de CierraCaja
        $cierre = new CierreCaja();
        $cierre->caja_id = $apertura->caja_id; // Suponiendo que el modelo CierraCaja tiene un campo caja_id
        $cierre->usuario_id = auth()->id(); // Si deseas registrar quién cerró la caja
        $cierre->monto_final_bolivares = $montoBs; // Asegúrate de que estos campos existan en tu request
        $cierre->monto_final_dolares = $montoDolar;
        //  $cierre->discrepancia_bolivares = $request->input('discrepancia_bolivares');
        // $cierre->discrepancia_dolares = $request->input('discrepancia_dolares');
        //$cierre->apertura_caja = $apertura->id; // Relacionando con la apertura de caja

        $cierre->save(); // Guardar el cierre

        $apertura->estado = 'Finalizado';
        $apertura->save();

        return redirect()->route('caja.pdf', $apertura->id);

    }

    public function aperturasIndex(){
        $aperturas = AperturaCaja::orderBy('id', 'DESC')->get();

        return view('caja.aperturas')->with('aperturas', $aperturas);
    }

    public function cierresIndex(){
        $aperturas = CierreCaja::orderBy('id', 'DESC')->get();

        return view('caja.cierres')->with('aperturas', $aperturas);
    }
}
