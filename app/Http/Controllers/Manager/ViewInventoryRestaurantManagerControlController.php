<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OwnerAdmin\RegisterBranch;
use App\Models\Manager\InventoryRestaurant;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Imagedb;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ViewInventoryRestaurantManagerControlController extends Controller
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
    public function store(Request $request)
    {
        //
        $validated = Validator::make($request->all(), [
            'menu_name'         => 'required|string|max:255',
            'menu_description'  => 'nullable|string',
            'menu_price'        => 'required|numeric|min:0',
            'menu_category'     => 'required|string|max:100',
            'id_branch'         => 'required|integer|exists:branches,id',
        ]);
        if ($validated->fails()) {
            return back()->withErrors($validated)->withInput();
        }
        $menu  = new InventoryRestaurant();
        $menu->menu_name = $request->menu_name;
        $menu->menu_description = $request->menu_description;
        $menu->menu_price = $request->menu_price;
        $menu->menu_category = $request->menu_category;
        $menu->id_users = Auth::id();
        $menu->id_branch = $request->id_branch;
        $menu->save();
        // Save uploaded images linked to the restaurant menu
        if ($request->has('imageUploads')) {
            foreach ($request->imageUploads as $path) {
                Imagedb::create([
                    'image_path'   => $path,
                    'id_restaurant' => $menu->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Menu added successfully.');
    }
    /**
     * Display the specified resource.
     */
     public function show(Request $request, $id)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $sortBy = $request->input('sortBy', 'menu_name'); // default column to sort
        $sortDirection = $request->input('sortDirection', 'asc');

        // find the branch based on its primary key or unique column
        $branch = RegisterBranch::with('user')
            ->where('b', $id) // adjust 'b' to the actual column name
            ->firstOrFail();

        // get all branches of the same user
        $branches = RegisterBranch::with('user')
            ->where('id_users', $branch->id_users)
            ->get();

        // build the retails query
        $restaurantsQuery = InventoryRestaurant::where('id_users', Auth::id())
            ->where('id_branch', $branch->id);

        if ($search) {
            $restaurantsQuery->where(function ($q) use ($search) {
                $q->where('menu_name', 'like', "%{$search}%")
                    ->orWhere('menu_category', 'like', "%{$search}%");
            });
        }
        $restaurantsQuery->orderBy($sortBy, $sortDirection);

        // paginate
        $restaurants = $restaurantsQuery->paginate($perPage);

        // apply search (if any)



        return Inertia::render('manager/InventoryList/ViewInventoryRestaurant', [
            'products'       => $branches,
            'branch'         => $branch,
            'restaurants'        => $restaurants,
            'perPage'        => (int) $perPage,
            'search'         => $search,
            'sortBy'         => $sortBy,
            'sortDirection'  => $sortDirection,
        ]);
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
public function destroy($id)
{
    // Find the menu by ID
    $menu = InventoryRestaurant::findOrFail($id);

    // Make sure only the owner (logged-in user) can delete
    if ($menu->id_users !== Auth::id()) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Get all images related to this menu
    $images = Imagedb::where('id_restaurant', $menu->id)->get();

    foreach ($images as $image) {
        // Delete file from storage if it exists
        if (Storage::exists($image->image_path)) {
            Storage::delete($image->image_path);
        }
        // Delete DB record
        $image->delete();
    }

    // Delete the menu itself
    $menu->delete();

    return redirect()->back()->with('success', 'Menu and its images deleted successfully.');
}
}
