<?php

namespace App\Exports;

use App\Models\Compra;
use App\Models\DetalleCompra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ComprasExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $start_date;
    protected $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        // Fetch the purchases within the provided date range
        $compras = Compra::whereBetween('created_at', [$this->start_date, $this->end_date])
            ->get();

        $data = [];

        foreach ($compras as $compra) {
            $productos = DetalleCompra::where('id_compra', $compra->id)
                ->with('producto') // Eager load product details
                ->get();

            // Prepare a list of product names, quantities, and net amounts
            $productos_list = $productos->map(function ($detalle) {
                return $detalle->producto->nombre . ' (Cantidad: ' . $detalle->cantidad . ', Neto: ' . $detalle->neto . ')';
            })->implode(', ');

            // Add the row to the data
            $data[] = [
                'proveedor' => $compra->proveedor->nombre, // Assuming 'nombre' is the column in 'proveedor' table
                'usuario' => $compra->user->name,
                'status' => $compra->status,
                'monto_total' => $compra->monto_total,
                'productos' => $productos_list,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Proveedor',
            'Usuario',
            'Status',
            'Monto Total',
            'Productos',
        ];
    }
}
