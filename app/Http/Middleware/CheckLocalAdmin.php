<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLocalAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get authenticated user
        $user = auth()->user();

        // If user is a local admin, only allow access to dashboard and pending-exams
        if ($user && $user->role === 'local admin') {
            $path = $request->path();
            
            // Allow access only to dashboard and pending-exams (progress ujian)
            $allowedPaths = [
                'admin/dashboard',
                'admin/pending-exams',
            ];
            
            // Check if current path is allowed
            $isAllowed = false;
            foreach ($allowedPaths as $allowedPath) {
                if (str_starts_with($path, $allowedPath)) {
                    $isAllowed = true;
                    break;
                }
            }
            
            // If path is not allowed, redirect to dashboard
            if (!$isAllowed) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'You do not have permission to access this page.');
            }
        }

        return $next($request);
    }
}