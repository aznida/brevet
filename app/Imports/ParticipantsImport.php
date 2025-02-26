<?php

namespace App\Imports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ParticipantsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Participant([
            'nik'          => (int) $row['nik'],
            'name'          => $row['name'],
            'password'      => $row['password'],
            'gender'        => $row['gender'],
            'area_id'  => (int) $row['area_id'],
        ]);
    }
    /**
     * rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nik' => 'unique:participants,nik',
        ];
    }
}
