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
            'option_1'      => $row['option_1'],
            'option_2'      => $row['option_2'],
            'option_3'      => $row['option_3'],
            'option_4'      => $row['option_4'],
            'option_5'      => $row['option_5'],
            'answer'        => $row['answer'],
            'level'        => $row['level'],
            'rating_scale'  => null
        ]);
    }
}
