<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/uploads/images', $filename);
            
            return response()->json([
                'location' => asset('storage/uploads/images/' . $filename)
            ]);
        }
        
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}