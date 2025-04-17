<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class PurchasesExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $courseId;
    protected $month;
    protected $purchases;

    public function __construct($courseId, $month)
    {
        $this->courseId = $courseId;
        $this->month = $month;

        $query = Purchase::with(['user', 'course', 'payment']);

        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        $this->purchases = $query->get();
    }

    public function collection()
    {
        return $this->purchases->map(function ($purchase) {
            return [
                'Nama User'     => $purchase->user->name ?? '-',
                'Judul Kursus'  => $purchase->course->title ?? '-',
                'Harga'         => optional($purchase->payment)->amount ?? 0,
                'Tanggal'       => $purchase->created_at->format('d M Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama User', 'Judul Kursus', 'Harga', 'Tanggal'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $rowCount = count($this->purchases) + 1;

                // Label total
                $sheet->setCellValue('C' . ($rowCount + 2), 'Total Pendapatan');

                // Formula total
                $sheet->setCellValue('D' . ($rowCount + 2), "=SUM(C2:C{$rowCount})");

                // Format kolom Harga dan Total
                $sheet->getStyle("C2:C{$rowCount}")
                      ->getNumberFormat()
                      ->setFormatCode('#,##0 "Rp"');

                $sheet->getStyle('D' . ($rowCount + 2))
                      ->getNumberFormat()
                      ->setFormatCode('#,##0 "Rp"');

                // Bold total row
                $sheet->getStyle('C' . ($rowCount + 2) . ':D' . ($rowCount + 2))
                      ->getFont()
                      ->setBold(true);
            },
        ];
    }
}
