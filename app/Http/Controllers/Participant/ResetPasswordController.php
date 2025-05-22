<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log; // Add this at the top with other imports

class ResetPasswordController extends Controller
{
    public function showResetForm(string $token)
    {
        return Inertia::render('Participant/Login/ResetPassword', [
            'token' => $token
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Debug logs
        Log::info('Reset Password Request:', [
            'token' => $request->token,
            'email' => $request->email,
            'password' => $request->password // Temporary for debugging
        ]);

        $passwordReset = DB::table('password_resets')
            ->where('token', $request->token)
            ->first();

        Log::info('Password Reset Record:', [
            'found' => $passwordReset ? 'yes' : 'no',
            'reset_data' => $passwordReset
        ]);

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Invalid token!']);
        }

        if ($passwordReset->email !== $request->email) {
            Log::info('Email Mismatch:', [
                'reset_email' => $passwordReset->email,
                'request_email' => $request->email
            ]);
            return back()->withErrors(['email' => 'Email address does not match!']);
        }

        $participant = Participant::where('email', $request->email)->first();

        Log::info('Participant Found:', [
            'found' => $participant ? 'yes' : 'no',
            'participant_data' => $participant
        ]);

        if (!$participant) {
            return back()->withErrors(['email' => 'We cannot find a participant with that email address.']);
        }

        // Temporarily store password without encryption
        $participant->password = $request->password;
        $participant->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        Log::info('Password reset completed', [
            'participant_email' => $participant->email,
            'new_password' => $request->password, // Temporary for debugging
            'reset_time' => now()->format('Y-m-d H:i:s')
        ]);

        return redirect('/')->with('status', 'Your password has been reset!');
    }
}