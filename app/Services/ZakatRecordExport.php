<?php

namespace App\Services;

use App\Models\ZakatRecord;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class ZakatRecordExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    protected $userIds;
    protected $jenis;

    public function __construct(array $userIds = [], ?string $jenis = null)
    {
        $this->userIds = $userIds;
        $this->jenis = $jenis;
    }

    public function collection(): Collection
    {
        $query = ZakatRecord::with('user');
        if (!empty($this->userIds)) {
            $query->whereIn('user_id', $this->userIds);
        }
        if ($this->jenis) {
            $query->byType($this->jenis);
        }
        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Warga',
            'Email',
            'Jenis Zakat',
            'Jiwa',
            'Beras (kg)',
            'Emas (gram)',
            'Total Nilai (Rp)',
            'Jatuh Tempo',
            'Tanggal Bayar',
            'Metode',
            'No. Referensi',
            'Keterangan',
            'Dicatat Pada',
        ];
    }

    public function title(): string
    {
        $prefix = 'pencatatan-zakat';
        if ($this->jenis) {
            $prefix .= '-' . $this->jenis;
        }
        return $prefix . '-' . now()->format('Y-m-d-His');
    }

    public function map($record): array
    {
        return [
            $record->id,
            $record->user->name ?? 'Tidak diketahui',
            $record->user->email ?? '-',
            $record->zakatTypeLabel(),
            $record->jiwa_count,
            $record->beras_kg,
            $record->gold_gram,
            (float) $record->total_amount,
            $record->due_date?->format('d M Y'),
            $record->payment_date?->format('d M Y'),
            $record->paymentMethodLabel(),
            $record->reference_number,
            $record->notes,
            $record->created_at?->format('d M Y H:i'),
        ];
    }
}
