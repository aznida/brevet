<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PendingExamsExport implements FromCollection, WithMapping, WithHeadings
{    
    protected $participants;
    
    public function __construct($participants) {
        $this->participants = $participants;
    }

    public function collection()
    {
        return $this->participants;
    }

    public function map($participant) : array {
        return [
            $participant->nik,
            $participant->name,
            $participant->area->title,
            $participant->witel,
            $participant->role,
            // Add exam status for each category
            $this->getExamStatus($participant, 'ASSESMENT PRAKTIK'),
            $this->getExamStatus($participant, 'AUTOMATION'),
            $this->getExamStatus($participant, 'ELECTRICAL'),
            $this->getExamStatus($participant, 'MAINTENANCE'),
            $this->getExamStatus($participant, 'MECHANICAL'),
            $this->getExamStatus($participant, 'MONITORING'),
        ];
    }
 
    public function headings() : array {
        return [
            'NIK',
            'Nama',
            'TREG',
            'Witel',
            'Job Role',
            'ASSESMENT PRAKTIK',
            'AUTOMATION',
            'ELECTRICAL',
            'MAINTENANCE',
            'MECHANICAL',
            'MONITORING'
        ];
    }

    private function getExamStatus($participant, $categoryTitle) {
        if (!$participant->grades || !$participant->grades->count()) return '❌';
        
        $categoryGrades = $participant->grades->filter(function($grade) use ($categoryTitle) {
            return $grade->exam?->category?->title === $categoryTitle;
        });

        if ($categoryGrades->isEmpty()) return '❌';

        $average = $categoryGrades->avg('grade');
        
        if (is_null($average)) return '❌';
        
        $grade = number_format($average, 2);
        if ($grade >= 91) return $grade . ' 💎';
        if ($grade >= 71) return $grade . ' 🥇';
        if ($grade >= 61) return $grade . ' 🥈';
        if ($grade >= 31) return $grade . ' 🥉';
        return $grade . ' 🌱';
    }
}