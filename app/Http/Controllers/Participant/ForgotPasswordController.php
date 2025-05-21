<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return inertia('Participant/Login/ForgotPassword');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'identifier' => 'required'
        ]);

        $participant = Participant::where('email', $request->identifier)
                                ->orWhere('nik', $request->identifier)
                                ->first();

        if (!$participant) {
            return back()->withErrors([
                'identifier' => 'We cannot find a participant with that NIK/email.'
            ]);
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $participant->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('emails.participant.forgot-password', [
            'token' => $token,
            'name' => $participant->name
        ], function($message) use ($participant) {
            $message->to($participant->email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('status', 'We have emailed your password reset link!');
    }
}