<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function image(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ]);

        $path = $request->file('file')->store('uploads/' . date('Y/m'), 'public');

        return response()->json([
            'location' => Storage::disk('public')->url($path),
        ]);
    }
}
