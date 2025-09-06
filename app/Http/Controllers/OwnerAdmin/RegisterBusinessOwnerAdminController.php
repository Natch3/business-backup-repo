<?php

namespace App\Http\Controllers\OwnerAdmin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\OwnerAdmin\RegisterBranch;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class RegisterBusinessOwnerAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

  public function index(Request $request)
    {
        // Get the authenticated user model
        $user = User::with('branches')->findOrFail(Auth::id());

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $sortBy = $request->input('sortBy', 'branch_name');
        $sortDirection = $request->input('sortDirection', 'asc');

        // Start building query using relationship
        $query = $user->branches();

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('branch_name', 'like', "%{$search}%")
                  ->orWhere('business_type', 'like', "%{$search}%");
            });
        }

        // Count all branches
        $totalBranches = $query->count();

        // Check branch limit
        $branchLimit = $user->branch_limit; // this always has a default value in DB
        $branchLimitReached = $totalBranches >= $branchLimit;

        // Add sorting
        if (in_array($sortBy, ['branch_name', 'business_type', 'status', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        // Paginate
        $branches = $query->paginate($perPage)->withQueryString();

        // Pass data to Inertia
        return inertia('owneradmin/RegisterBusiness', [
            'branches' => $branches,
            'totalBranches' => $totalBranches,
            'branchLimit' => $branchLimit,
            'branchLimitReached' => $branchLimitReached,
            'perPage' => (int) $perPage,
            'search' => $search,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
        ]);
    }


    /*
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
        $validated = Validator::make($request->all(), [
            'branch_name'     => 'required|string|max:255',
            'business_type'   => 'required|string|max:100',
            'address'         => 'required|string|max:255',
            'city'            => 'required|string|max:100',
            'province'        => 'required|string|max:100',
            'contact_number'  => 'required|string|max:20',
            'email'           => 'required|email|max:255',
            'branch_logo'     => 'nullable|string', // this is handled by filepond separately
        ]);

        if ($validated->fails()) {
            return back()->withErrors($validated)->withInput();
        }

        $registerbranches = new RegisterBranch();
        $registerbranches->branch_name = $request->branch_name;
        $registerbranches->business_type = $request->business_type;
        $registerbranches->address = $request->address;
        $registerbranches->city = $request->city;
        $registerbranches->province = $request->province;
        $registerbranches->contact_number = $request->contact_number;
        $registerbranches->email = $request->email;
        $registerbranches->branch_logo = $request->branch_logo; // just path string
        $registerbranches->id_users = Auth::id(); // Assuming user must be authenticated

        $registerbranches->save();

        return redirect()->back()->with('success', 'Branch added successfully.');
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
      $branch = RegisterBranch::where('id', $id)
                            ->where('id_users', Auth::id())
                            ->first();

    if (!$branch) {
        return redirect()->back()->with('error', 'Branch not found or unauthorized.');
    }
    if ($branch->branch_logo && Storage::disk('public')->exists($branch->branch_logo)) {
        Storage::disk('public')->delete($branch->branch_logo);
    }
    $branch->delete();

    return redirect()->back()->with('success', 'Branch deleted successfully.');
    }
}
