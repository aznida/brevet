<?php

namespace App\Http\Middleware;

use App\Models\Announcement;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShareAnnouncementsData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Hanya bagikan data jika user adalah participant yang sudah login
        if (auth()->guard('participant')->check()) {
            // Ambil pengumuman aktif
            $announcements = Announcement::where('is_active', true)
                                   ->orderBy('created_at', 'desc')
                                   ->get();
            
            // Bagikan ke semua halaman
            Inertia::share('announcements', $announcements);
        }
        
        return $next($request);
    }
}