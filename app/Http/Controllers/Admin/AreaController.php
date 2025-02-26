<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get areas
        $areas = Area::when(request()->q, function($areas) {
            $areas = $areas->where('title', 'like', '%'. request()->q . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $areas->appends(['q' => request()->q]);
        
        //render with inertia
        return inertia('Admin/Areas/Index', [
            'areas' => $areas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //render with inertia
        return inertia('Admin/Areas/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'title' => 'required|string|unique:areas'
        ]);

        //create classroom
        Area::create([
            'title' => $request->title,
        ]);

        //redirect
        return redirect()->route('admin.areas.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get area
        $area = Area::findOrFail($id);

        //render with inertia
        return inertia('Admin/Areas/Edit', [
            'area' => $area,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        //validate request
        $request->validate([
            'title' => 'required|string|unique:areas,title,'.$area->id,
        ]);

        //update area
        $area->update([
            'title' => $request->title,
        ]);

        //redirect
        return redirect()->route('admin.areas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get classroom
        $area = Area::findOrFail($id);

        //delete classroom
        $area->delete();

        //redirect
        return redirect()->route('admin.areas.index');
    }
}