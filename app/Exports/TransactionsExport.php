<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithStyles
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions->map(function ($trx) {
            return [
                'Tanggal' => $trx->date,
                'Deskripsi' => $trx->note,
                'Jumlah' => $trx->amount,
                'Tipe' => $trx->category->type,
                'Kategori' => $trx->category->name,
            ];
        });
    }

    public function headings(): array
    {
        return ['tanggal', 'deskripsi', 'jumlah', 'tipe', 'kategori'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}