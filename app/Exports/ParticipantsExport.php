<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParticipantsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
    public function collection()
    {
        return Participant::with('area')->get();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
            'Email',
            'No. HP',
            'TREG',
            'Witel/Kota',
            'Jenis Kelamin',
            'Masa Kerja',
            'Tanggal Lahir',
            'Job Role',
            'Status'
        ];
    }

    public function map($participant): array
    {
        return [
            $participant->nik,
            $participant->name,
            $participant->email,
            $participant->hp,
            $participant->area->title,
            $participant->witel,
            $participant->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            $participant->masa_kerja,
            $participant->tanggal_lahir,
            $participant->role,
            $participant->status
        ];
    }
}