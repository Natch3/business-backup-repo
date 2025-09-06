<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;

use App\Http\Requests\ProductsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Imagedb;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
// use Illuminate\Container\Attributes\Auth;
use App\Models\User;
use App\Models\OwnerAdmin\RegisterBranch;
use App\Models\OwnerAdmin\UserBranch;

class ProductsManagerController extends Controller
{

public function index()
{
    $userId = Auth::id();

    // Get all branches associated with the logged-in user
    $userBranchIds = UserBranch::where('id_users', $userId)->pluck('id_branch');

    // Fetch the branches themselves
    $branches = RegisterBranch::whereIn('id', $userBranchIds)->get();

    // Pass branches to Vue as products
    return Inertia::render('manager/Inventory', [
        'products' => $branches, // each branch has name, category/business_type, etc.
        'branch' => $branches->first() ?? null, // optional first branch for display
    ]);
}
//  public function store(Request $request)
// {
//     $request->validate([
//         'product_name' => 'required',
//         'price' => 'required',
//         'stock_quantity' => 'required',
//         'description' => 'required',
//         'image' => 'required|string', // this is just a path
//     ]);

//     $products = Products::create([
//         'product_name' => $request->product_name,
//         'price' => $request->price,
//         'stock_quantity' => $request->stock_quantity,
//         'description' => $request->description,
//         'id_users' => Auth::id(),
//     ]);

//     Imagedb::create([
//         'id_products' => $products->id,
//         'image_path' => $request->image,
//     ]);

//     return redirect()->back()->with('success', 'products created successfully with image.');
// }


    // public function destroy($id){
    //     $products = products::find($id);
    //     $products->delete();
    //     return redirect()->route("admin.ManageUser");
    // }
    
// public function destroy($id)
// {
//     $products = products::find($id);

//     if (!$products) {
//         return redirect()->route('manager.ManageUser')->with('error', 'products not found.');
//     }

//     $imageRecord = Imagedb::where('id_products', $products->id)->first();

//     if ($imageRecord) {
//         // Get full file system path to the image
//         $fullImagePath = public_path($imageRecord->image_path);

//         // Check if file exists and delete it
//         if (file_exists($fullImagePath)) {
//             unlink($fullImagePath);
//         }

//         $imageRecord->delete(); // Delete image DB record
//     }

//     $products->delete(); // Delete products DB record

//     return redirect()->route('manager.Inventory')->with('success', 'products and image file deleted.');
// }

}
