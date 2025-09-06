<?php

namespace App\Http\Controllers\AdminControl;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\OwnerAdmin\RegisterBranch;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

class DashboardAdminControlController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        $totalUsers = User::count();
        $totalApproved = RegisterBranch::where('status', 'Approved')->count();
        $totalPending = RegisterBranch::where('status', 'Pending')->count();
        $totalRejected = RegisterBranch::where('status', 'Rejected')->count();
        return Inertia::render("admincontrol/dashboard", [

            "totalUsers" => $totalUsers,
            "totalApproved" => $totalApproved,
            "totalPending" => $totalPending,
            "totalRejected" => $totalRejected,

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
