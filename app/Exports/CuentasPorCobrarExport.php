<?php

namespace App\Exports;

use App\Models\CuentaPorCobrar;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CuentasPorCobrarExport implements FromQuery, WithHeadings, ShouldAutoSize
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
        return CuentaPorCobrar::query()
             
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select(
                'id',
                'tipo',
                'descripcion',
                'monto',
                'estado',
                'venta_id'
            );
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tipo',
            'Descripción',
            'Monto',
            'Estado',
            'Venta ID',
            'Cliente',
        ];
    }

    public function map($cuenta): array
    {
        return [
            $cuenta->id,
            $cuenta->tipo,
            $cuenta->descripcion,
            $cuenta->monto,
            $cuenta->estado,
            $cuenta->venta_id,
            $cuenta->venta->user->name ?? 'N/A',
        ];
    }
}
