<?php

namespace App\Http\Controllers\Participant;

use App\Models\Announcement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get active announcements
        $announcements = Announcement::where('is_active', true)
                                    ->latest()
                                    ->get();

        //render with inertia
        return inertia('Participant/Pengumuman/Index', [
            'announcements' => $announcements,
        ])->with([
            'announcements' => $announcements,
        ]);
    }
}