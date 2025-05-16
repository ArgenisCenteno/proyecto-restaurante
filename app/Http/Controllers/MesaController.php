<?php
// app/Http/Controllers/MesaController.php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MesaController extends Controller
{
    public function index(Request $request)
    {
        
    
        if ($request->ajax()) {
            $productos = Mesa::get(); // Cargar la relación subCategoria

            return DataTables::of($productos)
               
                ->addColumn('actions', 'mesas.actions')
                ->rawColumns(['status', 'actions', 'fecha_vencimiento'])
                ->make(true);
        } else {
            return view('mesas.index');
        }
    }

    public function create()
    {
        return view('mesas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|unique:mesas,numero',
            'descripcion' => 'nullable|string',
        ]);

        Mesa::create($request->all());

        return redirect()->route('mesas.index')->with('success', 'Mesa registrada correctamente.');
    }

    public function edit(Mesa $mesa)
    {
        return view('mesas.edit', compact('mesa'));
    }

    public function update(Request $request, Mesa $mesa)
    {
        $request->validate([
            'numero' => 'required|unique:mesas,numero,' . $mesa->id,
            'descripcion' => 'nullable|string',
        ]);

        $mesa->update($request->all());

        return redirect()->route('mesas.index')->with('success', 'Mesa actualizada correctamente.');
    }

    public function destroy(Mesa $mesa)
    {
        $mesa->delete();
        return redirect()->route('mesas.index')->with('success', 'Mesa eliminada.');
    }
}
