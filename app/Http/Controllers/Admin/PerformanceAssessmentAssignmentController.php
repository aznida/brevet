<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerformanceAssessmentAssignment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PerformanceAssessmentAssignmentController extends Controller
{

    public function update(Request $request, $assessment_id, $assignment_id)
    {
        $assignment = PerformanceAssessmentAssignment::findOrFail($assignment_id);
        
        $request->validate([
            'assessor_id' => 'required|exists:participants,id',
            'assessee_id' => 'required|exists:participants,id',
            'status' => 'required|in:in_progress,completed'
        ]);

        $assignment->update($request->all());

        return redirect()
            ->route('admin.performance-assessments.show', $assessment_id)
            ->with('success', 'Assignment updated successfully');
    }

    public function destroy($assessment_id, $assignment_id)
    {
        $assignment = PerformanceAssessmentAssignment::findOrFail($assignment_id);
        $assignment->delete();

        return redirect()
            ->route('admin.performance-assessments.show', $assessment_id)
            ->with('success', 'Assignment deleted successfully');
    }
}