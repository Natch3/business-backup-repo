<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\OwnerAdmin\RegisterBranch;
use App\Models\OwnerAdmin\UserBranch;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();
        $role = $user->role;

        // If user is an OwnerAdmin, Manager, or Staff, check their subscription
        if (in_array($role, ['OwnerAdmin', 'Manager', 'Staff'])) {
            if (is_null($user->subscription_expires_at) || now()->greaterThan($user->subscription_expires_at)) {
                // Redirect to SubscriptionExpired page if subscription is expired or not active
                return redirect()->route('SubscriptionExpired.Expired');
            }
        }

        // Redirect based on role
        switch ($role) {
            case 'AdminControl':
                return redirect()->route('admincontrol.dashboard');

            case 'OwnerAdmin':
                return redirect()->route('owneradmin.dashboard');

            case 'Manager':
                return redirect()->route('manager.dashboard');
            case 'StaffRetail':
                return redirect()->route('staffpanel.staffretail.Dashboard');
            case 'StaffRestaurant':
                return redirect()->route('staffpanel.staffrestaurant.Dashboard');
            case 'StaffSalon':
                return redirect()->route('staffpanel.staffsalon.Dashboard');

            case 'Users':
                return redirect()->route('usersportal.dashboard');

            default:
                auth()->logout();
                return redirect()->route('login')->withErrors([
                    'role' => 'Unauthorized role detected.',
                ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
