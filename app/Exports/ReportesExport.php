<?php

namespace App\Exports;

use App\Models\Prestamo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportesExport implements FromCollection, WithHeadings, WithStyles
{
    protected $filtro;

    public function __construct($filtro)
    {
        $this->filtro = $filtro;
    }

    public function collection()
    {
        $query = Prestamo::with(['persona', 'herramienta']);

        // 🔎 FILTROS
        if ($this->filtro == 'hoy') {
            $query->whereDate('fecha_prestamo', now());
        }

        if ($this->filtro == 'semana') {
            $query->whereBetween('fecha_prestamo', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]);
        }

        if ($this->filtro == 'mes') {
            $query->whereMonth('fecha_prestamo', now()->month)
                ->whereYear('fecha_prestamo', now()->year);
        }

        return $query->get()->map(function ($r) {

            // 🧠 ESTADO INTELIGENTE
            $estado = 'Pendiente';

            if ($r->estado == 1) {
                if ($r->devolucion_real && $r->devolucion_real > $r->fecha_devolucion) {
                    $estado = 'Tarde';
                } else {
                    $estado = 'A tiempo';
                }
            } else {
                if (now() > $r->fecha_devolucion) {
                    $estado = 'No devuelto';
                }
            }

            return [
                $r->persona->nombre . ' ' . $r->persona->apaterno,
                $r->herramienta->nombre,
                $r->cantidad,
                $r->fecha_prestamo,
                $r->hora_prestamo,
                $r->fecha_devolucion,
                $r->devolucion_real ?? '---',
                $estado,
                $r->comentarios ?? '---'
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Persona',
            'Herramienta',
            'Cantidad',
            'Fecha Préstamo',
            'Hora',
            'Fecha Devolución',
            'Devolución Real',
            'Estado',
            'Comentarios'
        ];
    }

    // 🎨 ESTILO BONITO
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [ // fila de encabezados
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'DC3545'] // rojo bootstrap
                ],
            ],
        ];
    }
}
