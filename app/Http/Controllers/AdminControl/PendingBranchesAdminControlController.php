<?php

namespace App\Http\Controllers\AdminControl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OwnerAdmin\RegisterBranch;
use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
class PendingBranchesAdminControlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $perPage = $request->input('perPage', 10);
    $search = $request->input('search');
    $sortBy = $request->input('sortBy', 'name'); 
    $sortDirection = $request->input('sortDirection', 'asc');

    $query = User::with(['branches' => function($q) {
            $q->select('id', 'id_users', 'branch_name', 'status');
        }])
        ->withCount([
            'branches as pending_count' => function ($q) {
                $q->where('status', 'Pending');
            },
            'branches as total_branches' // ✅ count all branches
        ])
        ->whereHas('branches'); // only users with branches

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('branch_limit', 'like', "%{$search}%");
        });
    }

    if (in_array($sortBy, ['name', 'email', 'branch_limit', 'pending_count', 'total_branches', 'subscription_expires_at'])) {
        $query->orderBy($sortBy, $sortDirection);
    }

    $users = $query->paginate($perPage)->withQueryString();

    return Inertia::render('admincontrol/PendingBranches', [
        'PendingBranchs' => $users,
        'perPage' => (int) $perPage,
        'search' => $search,
        'sortBy' => $sortBy,
        'sortDirection' => $sortDirection,
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
        $validated = $request->validate([
        'status' => 'required|string|max:255',
    ]);
        $registerbranch = RegisterBranch::findOrFail($id);
    $registerbranch->status = $validated['status'];
    $registerbranch->save();
      return back()->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
