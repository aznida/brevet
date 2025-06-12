<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ParticipantController extends Controller
{
    /**
     * Display participant profile
     * 
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        // Get authenticated participant
        $participant = Auth::guard('participant')->user();
        
        // Decrypt password
        $decryptedPassword = Crypt::decryptString($participant->password);
        
        // Check if NIK and password are the same - pastikan keduanya string untuk perbandingan yang akurat
        $shouldShowUpdateModal = (string)$participant->nik === (string)$decryptedPassword;
        
        // Debug information
        $debug = [
            'nik' => $participant->nik,
            'decrypted_password' => $decryptedPassword,
            'should_show_modal' => $shouldShowUpdateModal
        ];
        
        return inertia('Participant/Profile/Index', [
            'shouldShowUpdateModal' => $shouldShowUpdateModal,
            'debug' => $debug
        ]);
    }

    /**
     * Show the form for editing participant profile
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // Get authenticated participant
        $participant = Auth::guard('participant')->user();
        
        // Get all areas for dropdown
        $areas = Area::all();
        
        return inertia('Participant/Profile/Edit', [
            'participant' => $participant,
            'areas' => $areas
        ]);
    }

    /**
     * Update participant profile
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Get authenticated participant
        $participant = Auth::guard('participant')->user();
        
        // Validate request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:participants,email,'.$participant->id,
            'hp' => 'required',
            'current_password' => 'nullable',
            'password' => 'nullable|confirmed|min:6',
        ]);
        
        // Update participant data
        $participant->update([
            'name' => $request->name,
            'email' => $request->email,
            'hp' => $request->hp,
        ]);
        
        // Check if password is provided
        if ($request->password) {
            // Verify current password if provided
            if ($request->current_password) {
                // Get the decrypted current password from database
                $currentPasswordFromDB = Crypt::decryptString($participant->password);
                
                // Check if current password matches
                if ($request->current_password !== $currentPasswordFromDB) {
                    return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
                }
            }
            
            // Update password
            $participant->update([
                'password' => Crypt::encryptString($request->password)
            ]);
        }
        
        return redirect()->route('participant.profile')->with('message', 'Profil berhasil diperbarui');
    }

    /**
     * Update participant credentials (email and password)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCredentials(Request $request)
    {
        // Get authenticated participant
        $participant = Auth::guard('participant')->user();
        
        // Validate request
        $request->validate([
            'email' => 'required|email|unique:participants,email,'.$participant->id,
            'password' => 'required|confirmed|min:6',
        ]);
        
        // Update participant data
        $participant->update([
            'email' => $request->email,
            'password' => Crypt::encryptString($request->password)
        ]);
        
        return redirect()->route('participant.profile')->with('message', 'Email dan password berhasil diperbarui');
    }
}