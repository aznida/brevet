<?php

namespace App\Http\Controllers\Participant;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //validate the form data
        $request->validate([
            'nik'      => 'required',
            'password'  => 'required',
        ]);

        //cek nisn dan password
        $participant = Participant::where([
            'nik'      => $request->nik,
            'password'  => $request->password
        ])->first();

        if(!$participant) {
            return redirect()->back()->with('error', 'NIK atau Password salah');
        }
        
        //login the user
        auth()->guard('participant')->login($participant);

        //redirect to dashboard
        return redirect()->route('participant.dashboard');
    }
}