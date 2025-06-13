<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get announcements
        $announcements = Announcement::when(request()->q, function($announcements) {
            $announcements = $announcements->where('title', 'like', '%'. request()->q . '%');
        })->latest()->paginate(10);

        //append query string to pagination links
        $announcements->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/Announcements/Index', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //render with inertia
        return inertia('Admin/Announcements/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        //create announcement
        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->is_active,
        ]);

        //redirect
        return redirect()->route('admin.announcements.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        //render with inertia
        return inertia('Admin/Announcements/Edit', [
            'announcement' => $announcement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        //validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        //update announcement
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->is_active,
        ]);

        //redirect
        return redirect()->route('admin.announcements.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        //delete announcement
        $announcement->delete();

        //redirect
        return redirect()->route('admin.announcements.index');
    }
}