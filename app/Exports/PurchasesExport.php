<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PurchasesExport implements FromArray, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $courseId;
    protected $month;
    protected $data = [];
    protected $rowStyles = [];
    protected $totalOverall = 0;

   public function __construct($courseId, $month)
    {
        $this->courseId = $courseId;
        $this->month = $month;

        $query = Purchase::with(['user', 'course', 'payment'])
            ->whereHas('payment', function ($q) {
                $q->where('transaction_status', 'success');
            })
            ->where('status', 'success')
            ->where('harga_course', '>', 0); // ⛔ Hindari pembelian manual

        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        $purchases = $query->get()
            ->sortBy(function ($purchase) {
                return $purchase->course->title ?? '';
            });

        // Kelompokkan data berdasarkan kursus
        $grouped = $purchases->groupBy('course.title');
        $currentRow = 2;

        foreach ($grouped as $courseTitle => $items) {
            $this->data[] = [$courseTitle];
            $this->rowStyles[] = $currentRow++;
            $subtotal = 0;

            foreach ($items as $purchase) {
                $this->data[] = [
                    $purchase->user->name ?? '-',
                    $purchase->course->title ?? '-',
                    $purchase->harga_course ?? 0,
                    $purchase->created_at->translatedFormat('d M Y'),
                ];
                $currentRow++;
                $subtotal += $purchase->harga_course ?? 0;
            }

            $this->data[] = ['', 'Total ' . $courseTitle, $subtotal, ''];
            $this->rowStyles[] = $currentRow++;
            $this->data[] = [''];
            $currentRow++;

            $this->totalOverall += $subtotal;
        }

        $this->data[] = [''];
        $this->data[] = ['', 'Total Keseluruhan', $this->totalOverall, ''];
        $this->rowStyles[] = $currentRow + 1;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return ['Nama User', 'Judul Kursus', 'Harga', 'Tanggal'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = count($this->data) + 1;

                // Format angka harga
                for ($i = 2; $i <= $highestRow; $i++) {
                    $value = $sheet->getCell("C{$i}")->getValue();
                    if (is_numeric($value)) {
                        $sheet->getStyle("C{$i}")
                            ->getNumberFormat()
                            ->setFormatCode('"Rp" #,##0');
                    }
                }

                // Bold & background heading
                $sheet->getStyle("A1:D1")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E0E0E0'],
                    ],
                ]);

                // Style untuk setiap blok judul kursus & total
                foreach ($this->rowStyles as $row) {
                    $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F8CBAD'], // warna pastel
                        ],
                    ]);
                }

                // Tambahkan border ke semua data
                $sheet->getStyle("A1:D{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '888888'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
