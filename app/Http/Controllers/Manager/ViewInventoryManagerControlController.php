<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OwnerAdmin\RegisterBranch;
class ViewInventoryManagerControlController extends Controller
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
          $request->validate([
            'id_branch'         => 'required|integer', // ensure branch exists if you have a branches table
            'menu_name'         => 'required|string|max:255',
            'menu_description'  => 'nullable|string',
            'menu_price'        => 'required|numeric|min:0',
            'menu_category'     => 'required|string|max:100',
        ]);

    }

    /**
     * Display the specified resource.
     */
public function show(Request $request, $id)
{
    // find the branch based on its primary key or unique column
    $branch = RegisterBranch::with('user')
        ->where('b', $id) // if 'b' is the column in your DB that matches item.b
        ->firstOrFail();

    // if you also want to fetch all branches of the same user
    $branches = RegisterBranch::with('user')
        ->where('id_users', $branch->id_users)
        ->get();

    return Inertia::render('manager/InventoryList/ViewInventory', [
        'products' => $branches, // all branches of that user
        'branch'   => $branch,   // the branch from the URL
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
    public function destroy(string $id)
    {
        //
    }
}
