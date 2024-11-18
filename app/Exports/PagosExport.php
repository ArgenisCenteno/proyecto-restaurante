<?php

namespace App\Exports;

use App\Models\Pago;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PagosExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Pago::query()
            ->whereBetween('fecha_pago', [$this->startDate, $this->endDate])
            ->select(
                'id',
                'tipo',
                'status',
               
                'forma_pago',
                'fecha_pago',
                'monto_total',
                'monto_neto',
                'descuento',
                'tasa_dolar',
            );
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tipo',
            'Status',
            'Forma de Pago',
            'Fecha de Pago',
            'Monto Total',
            'Monto Neto',
            'Descuento',
            'Tasa de Dólar',
        ];
    }
}
