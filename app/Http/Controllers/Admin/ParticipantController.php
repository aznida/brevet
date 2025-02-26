<?php

namespace App\Http\Controllers\Admin;

use App\Models\Participant;
use App\Models\Area;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ParticipantsImport;
use Maatwebsite\Excel\Facades\Excel;

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
            $participants = $participants->where('name', 'like', '%'. request()->q . '%');
        })->with('area')->latest()->paginate(5);

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
            'name'          => 'required|string|max:255',
            'nik'           => 'required|unique:participants',
            'gender'        => 'required|string',
            'password'      => 'required|confirmed',
            'area_id'       => 'required'
        ]);

        //create participant
        Participant::create([
            'name'          => $request->name,
            'nik'           => $request->nik,
            'gender'        => $request->gender,
            'password'      => $request->password,
            'area_id'       => $request->area_id
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
    public function edit(string $id)
    {
        //get participant
        $participant = Participant::findOrFail($id);

        //get classrooms
        $areas = Area::all();

        //render with inertia
        return inertia('Admin/Participants/Edit', [
            'participant' => $participant,
            'areas' => $areas,
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
            'name'          => 'required|string|max:255',
            'nik'           => 'required|unique:participants,nik,'.$participant->id,
            'gender'        => 'required|string',
            'area_id'       => 'required',
            'password'      => 'confirmed'
        ]);

        //check passwordy
        if($request->password == "") {

            //update participant without password
            $participant->update([
                'name'          => $request->name,
                'nik'           => $request->nik,
                'gender'        => $request->gender,
                'area_id'       => $request->area_id
            ]);

        } else {

            //update participant with password
            $participant->update([
                'name'          => $request->name,
                'nik'           => $request->nik,
                'gender'        => $request->gender,
                'password'      => $request->password,
                'area_id'       => $request->area_id
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
}
