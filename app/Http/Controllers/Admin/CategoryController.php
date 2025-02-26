<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get lessons
        $categories = Category::when(request()->q, function($categories) {
            $categories = $categories->where('title', 'like', '%'. request()->q . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $categories->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/Categories/Index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Admin/Categories/Create');
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
            'title' => 'required|string|unique:categories',
        ]);

        //create lesson
        Category::create([
            'title' => $request->title,
        ]);

        //redirect
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get lesson
        $category = Category::findOrFail($id);

        //render with inertia
        return inertia('Admin/Categories/Edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //validate request
        $request->validate([
            'title' => 'required|string|unique:categories,title,'.$category->id,
        ]);

        //update lesson
        $category->update([
            'title' => $request->title,
        ]);

        //redirect
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        //get lesson
        $category = Category::findOrFail($id);

        //delete lesson
        $category->delete();

        //redirect
        return redirect()->route('admin.categories.index');
    }
}
