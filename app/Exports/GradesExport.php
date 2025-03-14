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
        return [
            $grades->exam->title,
            $grades->exam_session->title,
            $grades->participant->name,
            $grades->exam->area->title,
            $grades->exam->category->title,
            $grades->grade,
        ] ;
    }
 
    public function headings() : array {
        return [
           'Ujian',
           'Sesi',
           'Nama Partisipan',
           'Area',
           'Kategori',
           'Hasil'
        ] ;
    }
}