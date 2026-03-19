<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('base_role')) {
    function base_role()
    {
        if (session()->has('base_role')) {
            return session('base_role');
        }

        if (Auth::check() && Auth::user()->role) {
            return Auth::user()->role->value;
        }

        return null;
    }
}

if (!function_exists('active_role')) {
    function active_role()
    {
        if (session()->has('active_role')) {
            return session('active_role');
        }

        if (Auth::check() && Auth::user()->role) {
            return Auth::user()->role->value;
        }

        return null;
    }
}

if (!function_exists('is_active_role')) {
    function is_active_role(string $role): bool
    {
        return active_role() === $role;
    }
}

if (!function_exists('is_base_role')) {
    function is_base_role(string $role): bool
    {
        return base_role() === $role;
    }
}