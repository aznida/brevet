public function create(Exam $exam)
{
    $exam = $exam->load(['category', 'area', 'questions']);
    
    return inertia('Admin/Questions/Create', [
        'exam' => $exam,
        'questions' => $exam->questions
    ]);
}