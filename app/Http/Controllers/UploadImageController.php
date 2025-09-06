<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            return response($path, 200); 
        }

        return response('Failed to upload image.', 400);
    }

 public function revert(Request $request)
{
    $data = $request->getContent(); // FilePond sends raw string
    $relativePath = str_replace('storage/', 'public/', $data); // adjust if needed

    if (Storage::exists($relativePath)) {
        Storage::delete($relativePath);
    }

    return response()->json(['status' => 'Image reverted.']);
}

}
