<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\File; // Import File facade

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return Inertia::render('Participant/Login/ForgotPassword');
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

        // Create password reset token
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $participant->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Generate reset link
        $resetLink = url('/participant/reset-password/'.$token);

        // Read the HTML template file
        $htmlTemplatePath = resource_path('views/emails/participant/forgot-password.html');
        $htmlContent = File::get($htmlTemplatePath);

        // Replace placeholders in the HTML content
        $htmlContent = str_replace('{name}', $participant->name, $htmlContent);
        $htmlContent = str_replace('{reset_link}', $resetLink, $htmlContent);

        // Send email using Mail::html()
        Mail::html($htmlContent, function($message) use ($participant) {
            $message->to($participant->email);
            $message->subject('Reset Password Notification');
        });

        // After sending email, add this:
        \Log::info('Email sent to: ' . $participant->email);
        \Log::info('Reset link: ' . $resetLink);

        return Inertia::render('Participant/Login/ForgotPassword', [
            'status' => 'We have emailed your password reset link!'
        ]);
    }
}