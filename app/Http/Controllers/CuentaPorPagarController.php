<?php

namespace App\Http\Controllers;

use App\Exports\CuentasPorPagarExport;
use App\Models\Compra;
use App\Models\CuentaPorPagar;
use App\Models\Pago;
use App\Models\Recibo;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Alert;
use Maatwebsite\Excel\Facades\Excel;
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
        // Obtener la cuenta por pagar
        $cuenta = CuentaPorPagar::findOrFail($id);
        
        // Validar que el monto del pago no sea mayor que el saldo pendiente
        $saldoRestante = $cuenta->monto - $cuenta->monto_pagado;
        $montoPago = $request->monto_pago;
    
    
        // Crear un nuevo registro de pago
        $pago = new Pago();
        $pago->tipo = 'Compra';
        $pago->status = 'Pagado'; // Puedes modificar esto según el estado de pago
        $pago->monto_total = $montoPago;
        $pago->monto_neto = $montoPago;
        $pago->forma_pago = $request->tipo_pago; // Suponiendo que es un JSON o un string
        $pago->creado_id = Auth::user()->id;
        $pago->fecha_pago = Carbon::now();
        $pago->save();
    
        // Actualizar el estado de la cuenta por pagar
        $cuenta->estado = $cuenta->monto_pagado + $montoPago >= $cuenta->monto ? 'Pagado' : 'Parcial';
        $cuenta->pago_id = $pago->id;
        $cuenta->monto_pagado += $montoPago; // Agregar el monto pagado
        $cuenta->save();
    
        // Crear un recibo para este pago
        $recibo = new Recibo();
        $recibo->tipo = 'Compra';
        $recibo->monto = $montoPago;
        $recibo->estatus = $pago->status;
        $recibo->pago_id = $pago->id;
        $recibo->user_id = $request->user_id;
        $recibo->activo = 1;
        $recibo->creado_id = Auth::user()->id;
        $recibo->descuento = $request->descuento ?? 0; // Descuento puede ser opcional
        $recibo->save();
    
        // Si la compra está completamente pagada, cambiar su estado a "Pagado"
        $compra = Compra::find($cuenta->compra_id);
        $compra->status = $cuenta->estado == 'Pagado' ? 'Pagado' : 'Parcial';
        $compra->pago_id = $pago->id;
        $compra->save();
    
        // Notificación de éxito
        Alert::success('¡Exito!', 'Pago registrado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        
        // Redirigir al usuario con mensaje de éxito
        return redirect()->route('cuentas-por-pagar.index')->with('success', 'Cuenta por pagar actualizada con éxito.');
    }
    

    // Eliminar una cuenta por pagar
    public function destroy($id)
    {
        $cuenta = CuentaPorPagar::findOrFail($id);
        $cuenta->delete();
        return redirect()->route('cuentas-por-pagar.index')->with('success', 'Cuenta por pagar eliminada con éxito.');
    }

    public function exportarCuentasPorPagar(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

           $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(new CuentasPorPagarExport($startDate, $endDate), 'cuentas_por_pagar.xlsx');
    }
}
