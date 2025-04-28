<?php

namespace App\Http\Controllers\Participant;

use App\Models\Participant;
use App\Models\Grade;
use App\Models\ExamGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        //get exam groups
        $exam_groups = ExamGroup::with('exam.category', 'exam_session', 'participant.area')
            ->where('participant_id', auth()->guard('participant')->user()->id)
            ->get();

        //define variable array
        $data = [];

        //get nilai
        foreach($exam_groups as $exam_group) {
            
            //get data nilai / grade
            $grade = Grade::where('exam_id', $exam_group->exam_id)
                ->where('exam_session_id', $exam_group->exam_session_id)
                ->where('participant_id', auth()->guard('participant')->user()->id)
                ->first();

            //jika nilai / grade kosong, maka buat baru
            if($grade == null) {

                //create defaul grade
                $grade = new Grade();
                $grade->exam_id         = $exam_group->exam_id;
                $grade->exam_session_id = $exam_group->exam_session_id;
                $grade->participant_id      = auth()->guard('participant')->user()->id;
                $grade->duration        = $exam_group->exam->duration * 60000;
                $grade->total_correct   = 0;
                $grade->grade           = 0;
                $grade->save();

            }

            $data[] = [
                'exam_group' => $exam_group,
                'grade'      => $grade
            ];

        }

        //return with inertia
        return inertia('Participant/Dashboard/Index', [
            'exam_groups' => $data,
        ]);
    }

    public function acceptPrivacy(Request $request)
    {
        try {
            $participant = $request->user('participant');  // Specify the guard
            
            if (!$participant) {
                \Log::error('Participant tidak ditemukan saat update PDP');
                return back()->with('error', 'Unauthorized');
            }
            
            $updated = $participant->update([
                'PDP' => 'true'
            ]);

            if (!$updated) {
                \Log::error('Gagal update PDP untuk participant ID: ' . $participant->id);
                throw new \Exception('Gagal mengupdate status PDP');
            }
    
            \Log::info('PDP berhasil diupdate:', [
                'id' => $participant->id,
                'PDP' => 'true'
            ]);
    
            return back()->with('success', 'Persetujuan privasi berhasil disimpan');
            
        } catch (\Exception $e) {
            \Log::error('Error saat update PDP: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan persetujuan');
        }
    }
}
