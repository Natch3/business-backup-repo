<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\OwnerAdmin\RegisterBranch;
use App\Models\OwnerAdmin\UserBranch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class AddAccountManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $userId = Auth::id();
    $perPage = $request->input('perPage', 10);
    $search = $request->input('search');
    $sortBy = $request->input('sortBy', 'name'); // default
    $sortDirection = $request->input('sortDirection', 'asc');

    // Get all branches associated with the logged-in user
    $userBranchIds = UserBranch::where('id_users', $userId)->pluck('id_branch');

    // Fetch the branches themselves
    $branches = RegisterBranch::whereIn('id', $userBranchIds)->get();

    // Build staff query first
$query = User::where('managers_id', $userId)
    ->whereIn('role', ['StaffRetail', 'StaffRestaurant', 'StaffSalon'])
    ->with(['userBranches' => function ($q) {
        $q->select('id', 'id_users', 'id_branch');
    }]);


    // Apply search
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Apply sorting
    if (in_array($sortBy, ['name', 'email', 'subscription_expires_at'])) {
        $query->orderBy($sortBy, $sortDirection);
    }

    // Now paginate
    $staff = $query->paginate($perPage);

    // Add branch info for each staff
    $staff->getCollection()->transform(function ($user) {
        $branchIDs = $user->userBranches->pluck('id_branch')->toArray();
        $user->branchIDList = $branchIDs;
        $user->branchNames = RegisterBranch::whereIn('id', $branchIDs)
            ->pluck('branch_name')
            ->toArray();
        return $user;
    });

    return Inertia::render('manager/AddAccount', [
        'products' => $branches,
        'branches' => $branches,
        'staff' => $staff, // now only staff, not the manager
        'parentId' => Auth::user()->parent_id,
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
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'id_branch' => ['required', Rule::exists('branches', 'id')], // branch id must exist
        'parent_id' => ['required', Rule::exists('users', 'id')],
    ]);

    // ✅ Get the selected branch
    $branch = RegisterBranch::findOrFail($request->id_branch);

    // ✅ Determine staff role based on business type
    $role = match ($branch->business_type) {
        'Retail' => 'StaffRetail',
        'Restaurant' => 'StaffRestaurant',
        'Salon' => 'StaffSalon',
        default => 'Staff', // fallback if type is unrecognized
    };

    // ✅ Create the staff user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $role, // set role based on branch business type
        'email_verified_at' => Carbon::now(),
        'parent_id' => $request->parent_id,
        'managers_id' => Auth::id(),
    ]);

    // ✅ Save the user-branch relation
    UserBranch::create([
        'id_users' => $user->id,
        'id_branch' => $request->id_branch,
    ]);

    return redirect()->back()->with('success', 'User created successfully with branch.');
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
   public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('manager/AddAccount')->with('error', 'Users not found.');
    }

    $user->delete(); // Delete products DB record

    return redirect()->back()->with('manager/AddAccount')->with('success', 'Users and image file deleted.');
}

}
