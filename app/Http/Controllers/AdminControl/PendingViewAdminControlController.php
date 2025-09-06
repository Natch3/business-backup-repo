<?php

namespace App\Http\Controllers\AdminControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OwnerAdmin\RegisterBranch;
use Inertia\Inertia;
class PendingViewAdminControlController extends Controller
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
    }

    /**
     * Display the specified resource.
     */
public function show(Request $request, $id)
{
    $perPage = $request->input('perPage', 10);
    $search = $request->input('search');
    $sortBy = $request->input('sortBy', 'branch_name');
    $sortDirection = $request->input('sortDirection', 'asc');

    $branchViews = RegisterBranch::with('user')
        ->where('id_users', $id)
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('branch_name', 'like', "%{$search}%")
                  ->orWhere('business_type', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('province', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        })
        ->orderBy($sortBy, $sortDirection)
        ->paginate($perPage)
        ->appends([
            'perPage' => $perPage,
            'search' => $search,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
        ]);

    return Inertia::render('admincontrol/branchesrequest/PendingView', [
        'branchViews'   => $branchViews,
        'perPage'       => $perPage,
        'search'        => $search,
        'sortBy'        => $sortBy,
        'sortDirection' => $sortDirection,
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
