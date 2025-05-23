<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\Participant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ParticipantsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $areaMapping;

    public function __construct()
    {
        $this->areaMapping = Area::pluck('id', 'title')->toArray();
    }

    public function model(array $row)
    {
        $areaTitle = $row['treg'] ?? null;
        $areaId = $this->areaMapping[$areaTitle] ?? null;

        // Handle Excel date format
        $birthDate = null;
        if (!empty($row['tanggal_lahir'])) {
            try {
                // Convert Excel date number to PHP DateTime
                $excelDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']);
                $birthDate = $excelDate->format('Y-m-d');
            } catch (\Exception $e) {
                // If conversion fails, try direct date parsing
                try {
                    $date = \DateTime::createFromFormat('m/d/Y', $row['tanggal_lahir']);
                    if ($date) {
                        $birthDate = $date->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $birthDate = null;
                }
            }
        }

        // Rest of the code remains the same
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = substr(str_shuffle($characters), 0, 8);

        return new Participant([
            'nik'           => (int) ($row['nik'] ?? 0),
            'name'          => $row['nama'] ?? '',
            'email'         => $row['email'] ?? '',
            'hp'            => (int) ($row['hp'] ?? 0),
            'witel'         => $row['witel'] ?? '',
            'password'      => bcrypt($password),
            'role'          => $row['role'] ?? 'Teknisi',
            'gender'        => $row['gender'] ?? 'L',
            'status'        => 'Aktif',
            'masa_kerja'    => $row['masa_kerja'] ?? 0,
            'tanggal_lahir' => $birthDate,
            'area_id'       => $areaId,
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => 'unique:participants,nik',
        ];
    }
}
