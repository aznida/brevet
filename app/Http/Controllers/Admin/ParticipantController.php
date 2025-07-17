<?php

namespace App\Http\Controllers\Admin;

use App\Models\Participant;
use App\Models\Area;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ParticipantsImport;
use App\Exports\ParticipantsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get participants
        $participants = Participant::when(request()->q, function($participants) {
            $participants = $participants->where(function($query) {
                $query->where('name', 'like', '%'. request()->q . '%')
                      ->orWhere('nik', 'like', '%'. request()->q . '%')
                      ->orWhere('witel', 'like', '%'. request()->q . '%')
                      ->orWhereHas('area', function($areaQuery) {
                          $areaQuery->where('title', 'like', '%'. request()->q . '%');
                      });
            });
        })->with(['area'])->latest()->paginate(50);

        // Dekripsi password untuk setiap partisipan
        foreach ($participants as $participant) {
            try {
                $participant->decrypted_password = Crypt::decryptString($participant->password);
            } catch (\Exception $e) {
                $participant->decrypted_password = '';
            }
        }

        //append query string to pagination links
        $participants->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/Participants/Index', [
            'participants' => $participants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //get areas
        $areas = Area::all();

        //render with inertia
        return inertia('Admin/Participants/Create', [
            'areas' => $areas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'nik'          => 'required|unique:participants',
            'name'         => 'required',
            'masa_kerja'   => 'nullable|integer|min:0',
            'tanggal_lahir'=> 'nullable|date_format:Y-m-d',
            'email'        => 'required|unique:participants',
            'hp'          => 'required',
            'witel'       => 'required',
            'area_id'     => 'required',
            'gender'      => 'required',
            'role'        => 'required',
            'status'      => 'required',
            'password'    => 'required|confirmed'
        ]);

        //create participant
        Participant::create([
            'nik'           => $request->nik,
            'name'          => $request->name,
            'masa_kerja'    => $request->masa_kerja,
            'tanggal_lahir' => $request->tanggal_lahir,
            'email'         => $request->email,
            'hp'           => $request->hp,
            'witel'        => $request->witel,
            'area_id'      => $request->area_id,
            'gender'       => $request->gender,
            'role'         => $request->role,
            'status'       => $request->status,
            'password'     => Crypt::encryptString($request->password)
        ]);

        //redirect
        return redirect()->route('admin.participants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Participant $participant)
    {
        //check if tanggal_lahir exists and is not null
        if ($participant->tanggal_lahir) {
            // Convert the datetime to just the date portion
            $participant->tanggal_lahir = date('Y-m-d', strtotime($participant->tanggal_lahir));
        }
        
        // Dekripsi password jika ada
        if ($participant->password) {
            try {
                $participant->decrypted_password = Crypt::decryptString($participant->password);
            } catch (\Exception $e) {
                $participant->decrypted_password = '';
            }
        }
        
        return inertia('Admin/Participants/Edit', [
            'participant' => $participant,
            'areas' => Area::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Participant $participant)
    {
        //validate request
        $request->validate([
            'nik'          => 'required|unique:participants,nik,'.$participant->id,
            'name'         => 'required',
            'masa_kerja'   => 'nullable|integer|min:0',
            'tanggal_lahir'=> 'nullable|date_format:Y-m-d',
            'email'        => 'required|unique:participants,email,'.$participant->id,
            'hp'          => 'required',
            'witel'       => 'required',
            'area_id'     => 'required',
            'gender'      => 'required',
            'role'        => 'required',
            'status'      => 'required',
            'password'    => 'nullable|confirmed'
        ]);

        //update participant without password
        $participant->update([
            'nik'           => $request->nik,
            'name'          => $request->name,
            'masa_kerja'    => $request->masa_kerja,
            'tanggal_lahir' => $request->tanggal_lahir,
            'email'         => $request->email,
            'hp'           => $request->hp,
            'witel'        => $request->witel,
            'area_id'      => $request->area_id,
            'gender'       => $request->gender,
            'role'         => $request->role,
            'status'       => $request->status,
        ]);

        //check if password is not empty
        if($request->password) {
            $participant->update([
                'password' => Crypt::encryptString($request->password)
            ]);
        }

        //redirect
        return redirect()->route('admin.participants.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        //get participant
        $participant = Participant::findOrFail($id);

        //delete participant
        $participant->delete();

        //redirect
        return redirect()->route('admin.participants.index');
    }
    /**
     * import
     *
     * @return void
     */
    public function import()
    {
        return inertia('Admin/Participants/Import');
    }
    
    /**
     * storeImport
     *
     * @param  mixed $request
     * @return void
     */
    public function storeImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // import data
        Excel::import(new ParticipantsImport(), $request->file('file'));

        //redirect
        return redirect()->route('admin.participants.index');
    }

    /**
     * Export participants to Excel
     */
    public function export() 
    {
        return Excel::download(new ParticipantsExport, 'participants.xlsx');
    }

    /**
     * Update privacy acceptance status
     */
    
}
