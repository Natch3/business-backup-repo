<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RedirectIfSubscriptionInvalidUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
 public function handle(Request $request, Closure $next)
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    // Default to checking the user's own subscription
    $subscriptionOwner = $user;

    // If user is Manager or Staff, use their OwnerAdmin's subscription
    if (in_array($user->role, ['Manager', 'Staff']) && $user->parent_id) {
        $subscriptionOwner = User::find($user->parent_id);
    }

    // Determine if the subscription is expired
    $isExpired = !$subscriptionOwner || 
                 !$subscriptionOwner->subscription_expires_at || 
                 now()->greaterThan($subscriptionOwner->subscription_expires_at);

    // If user has a valid subscription but tries to access the expired page, redirect them
    if (!$isExpired && $request->routeIs('usersportal.dashboard')) {
        switch ($user->role) {
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
            default:
                return redirect('SubscriptionExpired.Expired');
        }
    }

    return $next($request);
}

}
