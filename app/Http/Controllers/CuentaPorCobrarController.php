<?php
namespace App\Http\Controllers;

use App\Models\CuentaPorCobrar;
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
            $data = CuentaPorCobrar::with('pago')->get();

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
        return view('cuentas-por-cobrar.show', compact('cuenta'));
    }

    // Método para actualizar una cuenta por cobrar
    public function update(Request $request, $id)
    {
        $cuenta = CuentaPorCobrar::findOrFail($id);
        $cuenta->update($request->all());
        return response()->json($cuenta);
    }

    // Método para eliminar una cuenta por cobrar
    public function destroy($id)
    {
        $cuenta = CuentaPorCobrar::findOrFail($id);
        $cuenta->delete();
        return response()->json(null, 204);
    }
}
