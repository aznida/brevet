<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerformanceAssessment;
use App\Models\Participant;
use App\Models\Area;  // Add this import
use Illuminate\Http\Request;
use Inertia\Inertia;

class PerformanceAssessmentController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/PerformanceAssessments/Index', [
            'assessments' => PerformanceAssessment::with('area')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/PerformanceAssessments/Create', [
            'areas' => Area::orderBy('title')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'area_id' => 'required|exists:areas,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        PerformanceAssessment::create($validated);

        return redirect()->route('admin.performance_assessments.index');
    }

    public function assign(PerformanceAssessment $assessment)
    {
        $participants = Participant::all();
        return Inertia::render('Admin/PerformanceAssessments/Assign', [
            'assessment' => $assessment,
            'participants' => $participants
        ]);
    }

    public function storeAssessor(Request $request, PerformanceAssessment $assessment)
    {
        $validated = $request->validate([
            'assessor_id' => 'required|exists:participants,id',
            'assessee_id' => 'required|exists:participants,id|different:assessor_id',
        ]);
    
        // Check for existing assignment
        $exists = $assessment->assessments()
            ->where('assessor_id', $validated['assessor_id'])
            ->where('assessee_id', $validated['assessee_id'])
            ->exists();
    
        if ($exists) {
            return redirect()->back()
                ->withErrors(['duplicate' => 'This assessment pair already exists.'])
                ->withInput();
        }
    
        $assessment->assessments()->create([
            'assessment_id' => $assessment->id,
            'assessor_id' => $validated['assessor_id'],
            'assessee_id' => $validated['assessee_id'],
            'status' => 'in_progress'
        ]);
        
        return redirect()->route('admin.performance_assessments.show', $assessment->id);
    }

    public function show($id)
    {
        $assessment = PerformanceAssessment::with([
            'area',
            'assessments.assessor',
            'assessments.assessee'
        ])->findOrFail($id);

        // Debug the loaded data
        \Log::info('Show method assessment data:', [
            'id' => $assessment->id,
            'assessments_count' => $assessment->assessments->count(),
            'has_relationships' => [
                'area' => $assessment->area !== null,
                'assessments' => $assessment->assessments !== null
            ]
        ]);

        return Inertia::render('Admin/PerformanceAssessments/Show', [
            'assessment' => $assessment
        ]);
    }

    // When assessment starts
    public function startAssessment($id)
    {
        $assignment = PerformanceAssessmentAssignment::findOrFail($id);
        $assignment->update(['status' => 'in_progress']);
    }

    // When assessment ends
    public function endAssessment($id)
    {
        $assignment = PerformanceAssessmentAssignment::findOrFail($id);
        $assignment->update(['status' => 'completed']);
    }
}