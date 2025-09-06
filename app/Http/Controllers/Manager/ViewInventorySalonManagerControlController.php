<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OwnerAdmin\RegisterBranch;
use App\Models\Manager\InventorySalon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Imagedb;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ViewInventorySalonManagerControlController extends Controller
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
        //
        $validated = Validator::make($request->all(), [
            'service_name'         => 'required|string|max:255',
            'service_description'  => 'nullable|string', // accepts long text
            'service_category'     => 'required|string|max:100',
            'service_price'        => 'required|numeric|min:0',
            'service_duration'          => 'required|string|max:255',
            'service_stylist'         => 'required|string|max:100',
            'id_branch'         => 'required|integer|exists:branches,id',
        ]);
        if ($validated->fails()) {
            return back()->withErrors($validated)->withInput();
        }
        $salon  = new InventorySalon();
        $salon->service_name = $request->service_name;
        $salon->service_description = $request->service_description;
        $salon->service_category = $request->service_category;
        $salon->service_price = $request->service_price;
        $salon->service_duration = $request->service_duration;
        $salon->service_stylist = $request->service_stylist;
        $salon->id_users = Auth::id();
        $salon->id_branch = $request->id_branch;
        $salon->save();
        // Save uploaded images linked to the restaurant menu
        if ($request->has('imageUploads')) {
            foreach ($request->imageUploads as $path) {
                Imagedb::create([
                    'image_path'   => $path,
                    'id_salon' => $salon->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product added successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $sortBy = $request->input('sortBy', 'service_name'); // default column to sort
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
        $salonsQuery = InventorySalon::where('id_users', Auth::id())
            ->where('id_branch', $branch->id);

        if ($search) {
            $salonsQuery->where(function ($q) use ($search) {
                $q->where('service_name', 'like', "%{$search}%")
                    ->orWhere('service_category', 'like', "%{$search}%");
            });
        }
        $salonsQuery->orderBy($sortBy, $sortDirection);

        // paginate
        $salons = $salonsQuery->paginate($perPage);

        // apply search (if any)



        return Inertia::render('manager/InventoryList/ViewInventorySalon', [
            'products'       => $branches,
            'branch'         => $branch,
            'salons'        => $salons,
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
    $menu = InventorySalon::findOrFail($id);

    // Make sure only the owner (logged-in user) can delete
    if ($menu->id_users !== Auth::id()) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Get all images related to this menu
    $images = Imagedb::where('id_salon', $menu->id)->get();

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

    return redirect()->back()->with('success', 'Products and its images deleted successfully.');
}
}
