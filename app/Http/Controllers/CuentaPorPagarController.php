<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CuentaPorPagar;
use App\Models\Pago;
use App\Models\Recibo;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Alert;
class CuentaPorPagarController extends Controller
{
    // Mostrar todas las cuentas por pagar
    public function index()
    {
        $cuentas = CuentaPorPagar::with(['proveedor', 'user', 'pago'])->get();
        return view('cuentas_por_pagar.index', compact('cuentas'));
    }

    // Mostrar formulario para crear una nueva cuenta por pagar
    public function create()
    {
        return view('cuentas_por_pagar.create');
    }

    // Almacenar una nueva cuenta por pagar
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'user_id' => 'required|exists:users,id',
            'tipo' => 'required|string',
            'descripcion' => 'nullable|string',
            'pago_id' => 'nullable|exists:pagos,id',
            'monto' => 'required|numeric',
            'estado' => 'required|string',
        ]);

        CuentaPorPagar::create($validatedData);
        return redirect()->route('cuentas-por-pagar.index')->with('success', 'Cuenta por pagar creada con éxito.');
    }

    // Mostrar una cuenta específica
    public function show($id)
    {
        $cuenta = CuentaPorPagar::with(['proveedor', 'user', 'pago'])->findOrFail($id);
        return view('cuentas_por_pagar.show', compact('cuenta'));
    }

    // Mostrar formulario para editar una cuenta por pagar
    public function edit($id)
    {
        $cuenta = CuentaPorPagar::findOrFail($id);
        return view('cuentas_por_pagar.edit', compact('cuenta'));
    }

    // Actualizar una cuenta por pagar
    public function update(Request $request, $id)
    {
       

        $cuenta = CuentaPorPagar::findOrFail($id);
        $pago = new Pago();
        $pago->tipo = 'Compra';
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
        $recibo->tipo = 'Compra';
        $recibo->monto = $request->monto_pago;
        $recibo->estatus = $pago->status;
        $recibo->pago_id = $pago->id;
        $recibo->user_id = $request->user_id;
        $recibo->activo = 1;
        $recibo->creado_id = Auth::user()->id;
        $recibo->descuento = $request->descuento;
        $recibo->save();

        $compra = Compra::find($cuenta->compra_id);
        $compra->pago_id = $pago->id;
        $compra->status = 'Pagado';
        $compra->save();

        Alert::success('¡Exito!', 'Cuenta por pagar actualizada correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('cuentas-por-pagar.index')->with('success', 'Cuenta por pagar actualizada con éxito.');
    }

    // Eliminar una cuenta por pagar
    public function destroy($id)
    {
        $cuenta = CuentaPorPagar::findOrFail($id);
        $cuenta->delete();
        return redirect()->route('cuentas-por-pagar.index')->with('success', 'Cuenta por pagar eliminada con éxito.');
    }
}
