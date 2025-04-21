public function create(Exam $exam)
{
    // Explicitly load the category relationship
    $exam = $exam->load(['category']);
    
    return inertia('Admin/Questions/Create', [
        'exam' => $exam
    ]);
}