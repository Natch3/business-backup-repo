<?php

namespace App\Http\Controllers\OwnerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class UploadLogoOwnerAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
// In the same controller or UploadController
public function uploadImage(Request $request)
{
        if ($request->hasFile('branch_logo')) {
            $path = $request->file('branch_logo')->store('uploads', 'public');
            return response($path, 200); 
        }

        return response('Failed to upload Branch Logo.', 400);
    }


  public function revertLogo(Request $request)
    {
        $path = $request->input('path');

        if (!$path || !Storage::disk('public')->exists($path)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        Storage::disk('public')->delete($path);

        return response()->json(['message' => 'File deleted.'], 200);
    }

}
