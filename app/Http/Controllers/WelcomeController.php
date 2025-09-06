<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Products;
use App\Models\User;
use App\Models\OwnerAdmin\RegisterBranch;
use App\Models\OwnerAdmin\UserBranch;
use Illuminate\Support\Facades\Auth;
class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $user = Auth::user();


    if ($user) {
        // ✅ Get the branch id of the staff (only 1 branch)
        $userBranchId = UserBranch::where('id_users', $user->id)->value('id_branch');

        // ✅ Fetch that branch
        $branch = RegisterBranch::find($userBranchId);

    }

    // Existing logic
    $products = Products::first(); // Removed orderBy('views', 'desc')
    $totalUsers = User::count();

    return Inertia::render("Welcome", [
        "products" => $products ?? null,
        "totalUsers" => $totalUsers,

    ]);
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
    public function destroy(string $id)
    {
        //
    }
}
