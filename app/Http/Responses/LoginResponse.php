<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Log;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = auth()->user();
        
        // Log the user role for debugging
        Log::info('User login', [
            'user_id' => $user->id,
            'role' => $user->role,
        ]);
        
        // Redirect based on user role
        if ($user && $user->role === 'mitra') {
            return redirect()->route('admin.dashboard.mitra');
        }
        
        // Default redirect for other roles
        return redirect(config('fortify.home'));
    }
}