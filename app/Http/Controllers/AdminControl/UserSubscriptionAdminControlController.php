<?php

namespace App\Http\Controllers\AdminControl;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserSubscriptionAdminControlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $perPage = $request->input('perPage', 10);
    $search = $request->input('search');
    $sortBy = $request->input('sortBy', 'name'); // default
    $sortDirection = $request->input('sortDirection', 'asc');

    $query = User::whereIn('role', ['OwnerAdmin', 'Users']);

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

   // Add sorting
    if (in_array($sortBy, ['name', 'email', 'role', 'subscription_expires_at'])) {
        $query->orderBy($sortBy, $sortDirection);
    }


    $ownerAdmins = $query->paginate($perPage)->withQueryString();

    return Inertia::render('admincontrol/UserSubscription', [
        'ownerAdmins' => $ownerAdmins,
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
        'subscription_duration' => ['required', Rule::in(['1_month', '1_year'])],

    ]);

    // Calculate expiration based on selected duration
    $expiration = match ($request->subscription_duration) {
        '1_month' => Carbon::now()->addMonth(),
        '1_year' => Carbon::now()->addYear(),
    };

    // Create user with subscription expiration
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'OwnerAdmin',
        'subscription_expires_at' => $expiration,
        'email_verified_at'=> Carbon::now(),
    ]);


    return redirect()->back()->with('success', 'User created successfully with subscription.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'role' => ['required', 'string', Rule::in(['Users', 'OwnerAdmin'])],
        'subscription_expires_at' => ['nullable', Rule::in(['1_monthSub', '1_yearSub', 'Remove_Subscription'])],
        'password' => 'nullable|string|min:6|confirmed',
                 'branch_limit' => ['required', Rule::in([1, 2, 3, 4, 5])],
    ]);

    $user = User::findOrFail($id);

    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->role = $validated['role'];
        $user->branch_limit = $validated['branch_limit'];

    // Handle subscription
    if (array_key_exists('subscription_expires_at', $validated)) {
        if ($validated['subscription_expires_at'] === 'Remove_Subscription') {
            $user->subscription_expires_at = null; // Remove subscription
        } else {
            $user->subscription_expires_at = match ($validated['subscription_expires_at']) {
                '1_monthSub' => Carbon::now()->addMonth(),
                '1_yearSub' => Carbon::now()->addYear(),
                default => $user->subscription_expires_at,
            };
        }
    }

    if (!empty($validated['password'])) {
        $user->password = bcrypt($validated['password']);
    }

    $user->save();

    return back()->with('success', 'User updated successfully!');
}




    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->route('admincontrol.UserSubscription')->with('error', 'Users not found.');
    }

    $user->delete(); // Delete products DB record

    return redirect()->route('admincontrol.UserSubscription')->with('success', 'Users and image file deleted.');
}
}
