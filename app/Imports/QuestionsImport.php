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
        return new Question([
            'exam_id'       => $this->exam->id,
            'question'      => $row['question'],
            'question_type' => 'multiple_choice',
            'option_1'      => $row['a'],
            'option_2'      => $row['b'],
            'option_3'      => $row['c'],
            'option_4'      => $row['d'],
            'option_5'      => $row['e'],
            'answer'        => match(strtoupper($row['answer'])) {
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
