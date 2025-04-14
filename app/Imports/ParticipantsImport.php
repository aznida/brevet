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
        $areaTitle = $row['treg']; // Changed from 'Treg' to 'treg'
        $areaId = $this->areaMapping[$areaTitle] ?? null;

        // Generate 8 character random password
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = substr(str_shuffle($characters), 0, 8);

        return new Participant([
            'nik'           => (int) $row['nik'],      // Changed from 'NIK' to 'nik'
            'name'          => $row['nama'],           // Changed from 'Nama' to 'nama'
            'email'         => $row['email'],          // Changed from 'Email' to 'email'
            'hp'            => (int) $row['hp'],       // Changed from 'HP' to 'hp'
            'witel'         => $row['witel'],          // Changed from 'Witel' to 'witel'
            'password'      => $password,
            'gender'        => $row['gender'],         // Changed from 'Gender' to 'gender'
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
