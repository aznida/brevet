<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Participant;
use App\Models\Area;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //count participants
        $participants = Participant::count();

        //count exams
        $exams = Exam::count();

        //count exam sessions
        $exam_sessions = ExamSession::count();

        //count areas
        $areas = Area::count();

        return inertia('Admin/Dashboard/Index', [
            'participants'  => $participants,
            'exams'         => $exams,
            'exam_sessions' => $exam_sessions,
            'areas'         => $areas,
        ]);
    }
}