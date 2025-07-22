<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{

    /**
     * toResponse
     *
     * @param  mixed $request
     * @return void
     */
    public function toResponse($request)
    {
        // Debug logging
        Log::info('Logout response', [
            'has_participant_flag' => $request->session()->has('auth.participant_logout'),
            'user_type' => auth()->check() ? 'admin/user' : 'participant',
            'user_id' => auth()->id(),
        ]);
        
        // Check if the request is coming from a participant logout
        if ($request->session()->has('auth.participant_logout')) {
            // Clear the session flag
            $request->session()->forget('auth.participant_logout');
            // Redirect participants to homepage
            return redirect('/');
        }
        
        // Redirect admins and regular users to login page
        return redirect('/login');
    }
}