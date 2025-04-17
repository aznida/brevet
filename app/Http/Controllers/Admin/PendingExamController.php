<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Participant;
use App\Models\Area;
use App\Models\ExamSession;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Controllers\Category;
use Inertia\Inertia;

class PendingExamController extends Controller
{
    public function index()
    {
        $participants = Participant::with(['area', 'grades.exam.category'])
            ->when(request('q'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('witel', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $categories = Category::orderBy('title')->get();

        return Inertia::render('Admin/PendingExams/Index', [
            'participants' => $participants,
            'categories' => $categories
        ]);
    }
}