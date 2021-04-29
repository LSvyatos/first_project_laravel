<?php

namespace App\Http\Controllers\Vacancy\Images;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Upload extends Controller
{
    public function savePhoto(Request $request)
    {
        // Validate (size is in KB)
        $request->validate([
            'img' => 'required|file|image|dimensions:max_width=500,max_height=500',
        ]);

        // Read file contents...
        $contents = file_get_contents($request->photo->path());

        // ...or just move it somewhere else (eg: local `storage` directory or S3)
        $newPath = $request->photo->store('images');
    }
}
