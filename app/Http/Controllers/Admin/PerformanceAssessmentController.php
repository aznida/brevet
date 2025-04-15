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
        $request->validate([
            'assessor_id' => 'required|exists:participants,id',
            'assessee_id' => 'required|exists:participants,id|different:assessor_id',
        ]);

        $assessor = Participant::find($request->assessor_id);
        $assessee = Participant::find($request->assessee_id);

        if ($assessor->area_id !== $assessee->area_id) {
            return back()->withErrors(['message' => 'Participants must be in the same area']);
        }

        $assessment->assessments()->create([
            'assessor_id' => $request->assessor_id,
            'assessee_id' => $request->assessee_id,
            'status' => 'pending'
        ]);

        return redirect()->route('admin.performance_assessments.show', $assessment);
    }

    public function show(PerformanceAssessment $assessment)
    {
        $assignedAssessments = $assessment->assessments()->with(['assessor', 'assessee'])->get();
        return Inertia::render('Admin/PerformanceAssessments/Show', [
            'assessment' => $assessment,
            'assignedAssessments' => $assignedAssessments
        ]);
    }
}