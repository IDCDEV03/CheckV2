<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function handleRoot(): RedirectResponse
    {
        $user = Auth::user();

        if (! $user || ! $user->role) {
            return redirect()->route('login');
        }

        $baseRole = $user->role instanceof Role
            ? $user->role
            : Role::from($user->role);

        $activeRole = active_role() ?? $baseRole->value;

        // กัน active role แปลก ๆ
        $allowedRoles = ['admin', 'manager', 'agency', 'user'];
        if (! in_array($activeRole, $allowedRoles, true)) {
            $activeRole = $baseRole->value;
        }

        // กันเคส switch ไม่ถูกสิทธิ์
        if (
            $activeRole !== $baseRole->value &&
            ! (
                $baseRole === Role::Agency &&
                $activeRole === Role::User->value &&
                (bool) $user->can_switch === true
            )
        ) {
            $activeRole = $baseRole->value;
        }

        return match ($activeRole) {
            'admin' => redirect()->route('admin.dashboard'),
            'manager' => redirect()->route('manager.dashboard'),
            'agency' => redirect()->route('agency.index'),
            'user' => redirect()->route('local.home'),
            default => redirect()->route('login'),
        };
    }
}