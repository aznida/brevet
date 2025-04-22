<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\Exam;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionsImport implements ToModel, WithHeadingRow
{
    protected $exam;

    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $isAttitudeExam = str_contains(strtolower($this->exam->title), 'attitude') || 
                          str_contains(strtolower($this->exam->title), 'sikap') || 
                          str_contains(strtolower($this->exam->title), 'akhlak');

        return new Question([
            'exam_id'       => $this->exam->id,
            'question'      => $row['question'],
            'question_type' => 'multiple_choice',
            'option_1'      => $row['a'],
            'option_2'      => $row['b'],
            'option_3'      => $row['c'],
            'option_4'      => $row['d'],
            'option_5'      => $row['e'],
            'option_1_weight' => $isAttitudeExam ? ($row['a_bobot'] ?? null) : null,
            'option_2_weight' => $isAttitudeExam ? ($row['b_bobot'] ?? null) : null,
            'option_3_weight' => $isAttitudeExam ? ($row['c_bobot'] ?? null) : null,
            'option_4_weight' => $isAttitudeExam ? ($row['d_bobot'] ?? null) : null,
            'option_5_weight' => $isAttitudeExam ? ($row['e_bobot'] ?? null) : null,
            'answer'        => $isAttitudeExam ? null : match(strtoupper($row['answer'])) {
                'A' => '1',
                'B' => '2',
                'C' => '3',
                'D' => '4',
                'E' => '5',
                default => $row['answer'],
            },
            'level'        => $row['level'],
            'rating_scale'  => null
        ]);
    }
}
