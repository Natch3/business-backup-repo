<?php

namespace App\Http\Controllers\OwnerAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OwnerAdmin\RegisterBranch;
use App\Models\OwnerAdmin\UserBranch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Carbon\Carbon;
class ManagerAccountOwnerAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $userId = Auth::id();

$branches = RegisterBranch::where('id_users', $userId)
    ->where('status', '!=', 'Pending') // ✅ exclude Pending
    ->select('id', 'branch_name')
    ->get();

$managers = User::where('parent_id', $userId)
    ->where('role', 'Manager')
    ->with(['userBranches' => function($query) {
        $query->select('id', 'id_users', 'id_branch'); // select needed columns
    }])
    ->paginate(10);

// Add branchIDList and branchNames for each manager
$managers->getCollection()->transform(function($manager) {
    $branchIDs = $manager->userBranches->pluck('id_branch')->toArray();
    $manager->branchIDList = $branchIDs;

    // Get branch names from RegisterBranch where id matches id_branch
    $manager->branchNames = RegisterBranch::whereIn('id', $branchIDs)
        ->pluck('branch_name')
        ->toArray();

    return $manager;
});

    return inertia('owneradmin/ManagerAccount', [
        'branches' => $branches,
        'managers' => $managers
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
     * 
     */
    
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'id_branch' => ['required', 'array'],
        'id_branch.*' => [Rule::exists('branches', 'id')],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'Manager',
        'email_verified_at'=> Carbon::now(),
        'parent_id' => Auth::id(), 
    ]);

    // Save each branch with timestamps auto-filled
    foreach ($request->id_branch as $branchId) {
        $userBranch = new UserBranch();
        $userBranch->id_users = $user->id;
        $userBranch->id_branch = $branchId;
        $userBranch->save(); // auto fills created_at and updated_at
    }

    return redirect()->back()->with('success', 'User created successfully with branches.');
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
        return redirect()->back()->with('error', 'Branch not found or unauthorized.');
     }

    $user->delete(); // Delete products DB record

    return redirect()->back()->with('success', 'Branch deleted successfully.');
   }
}
