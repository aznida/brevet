<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\ExamGroup;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class ExamSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get exam_sessions
        $exam_sessions = ExamSession::when(request()->q, function($exam_sessions) {
            $exam_sessions = $exam_sessions->where('title', 'like', '%'. request()->q . '%');
        })->with('exam.area', 'exam.category', 'exam_groups.participant.area')->latest()->paginate(5);

        //append query string to pagination links
        $exam_sessions->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/ExamSessions/Index', [
            'exam_sessions' => $exam_sessions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get exams
        $exams = Exam::all();
        
        //render with inertia
        return inertia('Admin/ExamSessions/Create', [
            'exams' => $exams,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'title'         => 'required',
            'exam_id'       => 'required',
            'start_time'    => 'required',
            'end_time'      => 'required',
        ]);

        //create exam_session
        ExamSession::create([
            'title'         => $request->title,
            'exam_id'       => $request->exam_id,
            'start_time'    => date('Y-m-d H:i:s', strtotime($request->start_time)),
            'end_time'      => date('Y-m-d H:i:s', strtotime($request->end_time)),
        ]);

        //redirect
        return redirect()->route('admin.exam_sessions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $exam_session
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get exam_session
        $exam_session = ExamSession::with('exam.area', 'exam.category')->findOrFail($id);

        //get relation exam_groups with pagination
        $exam_session->setRelation('exam_groups', $exam_session->exam_groups()->with('participant.area')->paginate(5));

        //render with inertia
        return inertia('Admin/ExamSessions/Show', [
            'exam_session'  => $exam_session,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get exam_session
        $exam_session = ExamSession::findOrFail($id);
        
        //get exams
        $exams = Exam::all();
        
        //render with inertia
        return inertia('Admin/ExamSessions/Edit', [
            'exam_session'  => $exam_session,
            'exams'         => $exams,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamSession $exam_session)
    {
        //validate request
        $request->validate([
            'title'         => 'required',
            'exam_id'       => 'required',
            'start_time'    => 'required',
            'end_time'      => 'required',
        ]);
        
        //update exam_session
        $exam_session->update([
            'title'         => $request->title,
            'exam_id'       => $request->exam_id,
            'start_time'    => date('Y-m-d H:i:s', strtotime($request->start_time)),
            'end_time'      => date('Y-m-d H:i:s', strtotime($request->end_time)),
        ]);
        
        //redirect
        return redirect()->route('admin.exam_sessions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get exam_session
        $exam_session = ExamSession::findOrFail($id);
        
        //delete associated feedback records first
        DB::table('participant_feedback')->where('exam_session_id', $id)->delete();
        
        //delete exam_session
        $exam_session->delete();
        
        //redirect
        return redirect()->route('admin.exam_sessions.index');
    }

    /**
     * createEnrolle
     *
     * @param  mixed $exam_session
     * @return void
     */
    public function createEnrolled(ExamSession $exam_session)
    {
        //get exams
        $exam = $exam_session->exam;

        //get participants already enrolled
        $participants_enrolled = ExamGroup::where('exam_id', $exam->id)
            ->where('exam_session_id', $exam_session->id)
            ->pluck('participant_id')
            ->all();
        
        //get participants based on area
        if ($exam->area->title === 'Nasional') {
            $participants = Participant::with('area')
                ->whereNotIn('id', $participants_enrolled)
                ->get();
        } else {
            $participants = Participant::with('area')
                ->where('area_id', $exam->area_id)
                ->whereNotIn('id', $participants_enrolled)
                ->get();
        }

        //render with inertia
        return inertia('Admin/ExamGroups/Create', [
            'exam'          => $exam,
            'exam_session'  => $exam_session,
            'participants'  => $participants,
        ]);
    }

    /**
     * storeEnrolled
     *
     * @param  mixed $exam_session
     * @return void
     */
    public function storeEnrolled(Request $request, ExamSession $exam_session)
    {
        //validate request
        $request->validate([
            'participant_id'    => 'required',
        ]);
        
        //create exam_group
        foreach($request->participant_id as $participant_id) {

            //select participant
            $participant = Participant::findOrFail($participant_id);

            //create exam_group
            ExamGroup::create([
                'exam_id'         => $request->exam_id,  
                'exam_session_id' => $exam_session->id,
                'participant_id'      => $participant->id,
            ]);
        }
        
        //redirect
        return redirect()->route('admin.exam_sessions.show', $exam_session->id);
    }
    /**
     * destroyEnrolle
     *
     * @param  mixed $exam_session
     * @param  mixed $exam_group
     * @return void
     */
    public function destroyEnrolled(ExamSession $exam_session, ExamGroup $exam_group)
    {
        //delete exam_group
        $exam_group->delete();
        
        //redirect
        return redirect()->route('admin.exam_sessions.show', $exam_session->id);
    }

    /**
     * Send notifications to participants
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Send notifications to participants
     *
     * @return \Illuminate\Http\Response
     */
    public function sendNotifications(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'participant_ids' => 'required|array',
                'participant_ids.*' => 'exists:participants,id'
            ]);
    
            $successCount = 0; 
            $failedCount = 0;
            $failedEmails = [];
    
            // Ambil data peserta yang dipilih saja
            $participants = DB::table('participants')
                ->whereIn('id', $request->participant_ids)
                ->select('email', 'name', 'nik', 'password')
                ->get();
    
            foreach($participants as $participant) {
                // Ganti kode pengiriman langsung dengan dispatch job
                try {
                    $decryptedPassword = Crypt::decryptString($participant->password);
                    
                    // Dispatch job untuk mengirim email
                    SendParticipantNotification::dispatch(
                        $participant->email,
                        $participant->name,
                        $participant->nik,
                        $decryptedPassword
                    );
                    
                    \Log::info('Job pengiriman email di-dispatch untuk: ' . $participant->email);
                    $successCount++;
                } catch (\Exception $e) {
                    \Log::error('Gagal memproses email untuk ' . $participant->email . ': ' . $e->getMessage());
                    $failedCount++;
                    $failedEmails[] = $participant->email;
                    continue;
                }
            }
    
            $message = "Notifikasi berhasil dikirim ke {$successCount} peserta";
            if ($failedCount > 0) {
                $message .= ", gagal mengirim ke {$failedCount} peserta";
            }
    
            $responseData = [
                'type' => 'success',
                'message' => $message,
                'details' => [
                    'success' => $successCount,
                    'failed' => $failedCount,
                    'failed_emails' => $failedEmails,
                    'timestamp' => now()->format('d M Y H:i:s')
                ]
            ];
    
            // Jika request adalah dari Inertia, kembalikan respons Inertia
            if ($request->header('X-Inertia')) {
                return redirect()->back()->with($responseData);
            }
            
            // Jika request adalah AJAX/XHR atau meminta JSON, kembalikan respons JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($responseData);
            }
    
            // Jika bukan AJAX atau Inertia, lakukan redirect dengan flash data
            return back()->with($responseData);
    
        } catch (\Exception $e) {
            \Log::error('Error pada proses pengiriman email: ' . $e->getMessage());
            
            $errorData = [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
            
            // Jika request adalah dari Inertia, kembalikan respons Inertia
            if ($request->header('X-Inertia')) {
                return redirect()->back()->with($errorData);
            }
            
            // Jika request adalah AJAX/XHR atau meminta JSON, kembalikan respons JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($errorData, 500);
            }
            
            // Jika bukan AJAX atau Inertia, lakukan redirect dengan flash data
            return back()->with($errorData);
        }
    }
}
