<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GradesExport implements FromCollection, WithMapping, WithHeadings
{    
    /**
     * grade
     *
     * @var mixed
     */
    protected $grades;
    
    /**
     * __construct
     *
     * @param  mixed $grade
     * @return void
     */
    public function __construct($grades) {
        $this->grades = $grades;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->grades;
    }

    public function map($grades) : array {
        // Calculate level based on grade
        $level = match(true) {
            $grades->grade >= 91 => 'Expert 💎',
            $grades->grade >= 71 => 'Advanced 🥇',
            $grades->grade >= 61 => 'Intermediate 🥈',
            $grades->grade >= 31 => 'Basic 🥉',
            default => 'Starter 🌱'
        };

        return [
            $grades->participant->name,
            $grades->participant->area->title,
            $grades->participant->witel,
            $grades->exam->title,
            $grades->exam_session->title,
            $grades->exam->area->title,
            $grades->exam->category->title,
            $grades->grade,
            $level,
        ];
    }
 
    public function headings() : array {
        return [
           'Nama Partisipan',
           'TREG',
           'Witel',
           'Ujian',
           'Sesi',
           'Area Ujian',
           'Kategori',
           'Hasil',
           'Level Stream'
        ];
    }
}