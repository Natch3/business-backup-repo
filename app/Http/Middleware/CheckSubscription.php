<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckSubscription
{
public function handle(Request $request, Closure $next)
{
    $user = Auth::user();

    if (!$user) return redirect()->route('login');

    // Check if the user is an OwnerAdmin
    if ($user->role === 'OwnerAdmin') {
        if (is_null($user->subscription_expires_at) || now()->gt($user->subscription_expires_at)) {
            return redirect()->route('SubscriptionExpired.Expired');
        }
    }

    // If the user is Manager or Staff
    if (in_array($user->role, ['Manager', 'StaffSalon','StaffRetail','StaffRestaurant'])) {
        $owner = User::find($user->parent_id);
        if (!$owner || is_null($owner->subscription_expires_at) || now()->gt($owner->subscription_expires_at)) {
            return redirect()->route('SubscriptionExpired.Expired');
        }
    }

    return $next($request);
}

}
