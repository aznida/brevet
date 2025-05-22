<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

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

        $passwordReset = DB::table('password_resets')
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Invalid token!']);
        }

        if (!$passwordReset->email === $request->email) {
            return back()->withErrors(['email' => 'Email address does not match!']);
        }

        $participant = Participant::where('email', $request->email)->first();

        if (!$participant) {
            return back()->withErrors(['email' => 'We cannot find a participant with that email address.']);
        }

        $participant->password = Hash::make($request->password);
        $participant->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('participant.login')->with('status', 'Your password has been reset!');
    }
}