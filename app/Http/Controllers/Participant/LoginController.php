<?php

namespace App\Http\Controllers\Participant;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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

        //cari participant berdasarkan NIK
        $participant = Participant::where('nik', $request->nik)->first();

        //cek apakah participant ditemukan dan password sesuai
        if(!$participant || !Hash::check($request->password, $participant->password)) {
            return redirect()->back()->with('error', 'NIK atau Password salah');
        }
        
        //login the user
        auth()->guard('participant')->login($participant);

        //redirect to dashboard
        return redirect()->route('participant.dashboard');
    }
}