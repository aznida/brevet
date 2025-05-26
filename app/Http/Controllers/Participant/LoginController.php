<?php

namespace App\Http\Controllers\Participant;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        //validate the form data
        $request->validate([
            'nik'      => 'required',
            'password'  => 'required',
        ]);

        //cari participant berdasarkan NIK
        $participant = Participant::where('nik', $request->nik)->first();

        //cek apakah participant ditemukan
        if (!$participant) {
            return redirect()->back()->with('error', 'NIK atau Password salah');
        }

        try {
            //decrypt password dan cek kecocokan
            $decryptedPassword = Crypt::decryptString($participant->password);
            if ($request->password !== $decryptedPassword) {
                return redirect()->back()->with('error', 'NIK atau Password salah');
            }
        } catch (\Exception $e) {
            \Log::error('Error decrypting password: ' . $e->getMessage());
            return redirect()->back()->with('error', 'NIK atau Password salah');
        }
        
        //login the user
        auth()->guard('participant')->login($participant);

        //redirect to dashboard
        return redirect()->route('participant.dashboard');
    }
}