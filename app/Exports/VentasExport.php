<?php
namespace App\Exports;

use App\Models\Venta;
use App\Models\DetalleVenta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VentasExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        // Fetch the sales between the start and end date
        $ventas = Venta::whereBetween('created_at', [$this->start_date, $this->end_date])
            ->get();

        $data = [];

        foreach ($ventas as $venta) {
            $productos = DetalleVenta::where('id_venta', $venta->id)
                ->with('producto') // Eager load product details
                ->get();

            $productos_list = $productos->map(function ($detalle) {
                return $detalle->producto->nombre . ' (Cantidad: ' . $detalle->cantidad . ', Neto: ' . $detalle->neto . ')';
            })->implode(', ');

            $data[] = [
                'vendedor' => $venta->vendedor->name, // Assuming name is the column in the user table
                'usuario' => $venta->user->name,
                'status' => $venta->status,
                'monto_total' => $venta->monto_total,
                'mesa' => $venta->mesa,
                'productos' => $productos_list,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Vendedor',
            'Usuario',
            'Status',
            'Monto Total',
            'Mesa',
            'Productos',
        ];
    }
}
