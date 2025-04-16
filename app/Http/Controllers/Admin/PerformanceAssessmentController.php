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
            'assessee_id' => 'required|exists:participants,id',
        ]);

        $assessment->assessments()->create([
            'assessment_id' => $assessment->id,
            'assessor_id' => $validated['assessor_id'],
            'assessee_id' => $validated['assessee_id'],
            'status' => 'pending'
        ]);
        
        return redirect()->back();
    }

    public function show($id)  // Change parameter to $id instead of model binding
    {
        $assessment = PerformanceAssessment::with([
            'area',
            'assessments.assessor',
            'assessments.assessee'
        ])->findOrFail($id);
    
        // Debug the loaded data
        \Log::info('Assessment data:', [
            'id' => $assessment->id,
            'area_id' => $assessment->area_id,
            'assessments' => $assessment->assessments->count(),
            'sql' => $assessment->toSql()
        ]);
    
        return Inertia::render('Admin/PerformanceAssessments/Show', [
            'assessment' => $assessment
        ]);
    }
}