<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class UploadImageManagerControlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function uploadImage(Request $request)
    {
        $paths = [];

        if ($request->hasFile('imageUploads')) {
            $files = $request->file('imageUploads');

            if (!is_array($files)) $files = [$files];

            foreach ($files as $file) {
                $paths[] = $file->store('uploads', 'public');
            }

            return response()->json($paths, 200); // return array of file paths
        }

        return response()->json(['message' => 'No files uploaded'], 400);
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
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
public function revertLogo(Request $request)
{
    $filePath = $request->input('path'); // e.g. "storage/uploads/xyz.jpg"

    // Remove "storage/" prefix so it matches real storage/app/uploads path
    $relativePath = str_replace('storage/', '', $filePath); // "uploads/xyz.jpg"

    if (Storage::exists($relativePath)) {
        Storage::delete($relativePath);
        return response()->json(['status' => 'Image reverted.']);
    }

    return response()->json(['status' => 'File not found.'], 404);
}


}
