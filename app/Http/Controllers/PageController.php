<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Enums\Role;

class PageController extends Controller
{
    public function home()
    {
        $user = Auth::user();

        if (! $user) {
            abort(403);
        }

        $baseRole = $user->role;
        $activeRole = active_role();

        // อนุญาตเฉพาะ role ที่ระบบรองรับ
        if (! in_array($activeRole, ['admin', 'manager', 'agency', 'user'], true)) {
            abort(403);
        }

        // กันเคส switch แบบไม่ถูกสิทธิ์
        if ($activeRole === 'user' && $baseRole === Role::Agency && ! $user->can_switch) {
            abort(403);
        }

        $layout = match ($activeRole) {
            'admin'   => 'layout.LayoutAdmin',
            'manager' => 'layout.manager',
            'agency'  => 'layout.app',
            'user'    => 'layout.app',
        };

        $title = match ($activeRole) {
            'admin'   => 'ผู้ดูแลระบบ',
            'manager' => 'แดชบอร์ดผู้จัดการ',
            'agency'  => 'หน้าหลักหน่วยงาน',
            'user'    => 'แดชบอร์ดผู้ใช้งานทั่วไป',
        };

        $description = match ($activeRole) {
            'admin'   => 'ผู้ดูแลระบบ',
            'manager' => 'แดชบอร์ดผู้จัดการ',
            'agency'  => 'สำหรับหน่วยงาน',
            'user'    => 'แดชบอร์ดผู้ใช้งานทั่วไป',
        };

        if ($activeRole === 'user') {
            $vehicles = DB::table('vehicles')
                ->join('vehicle_types', 'vehicles.veh_type', '=', 'vehicle_types.id')
                ->select('vehicles.*', 'vehicle_types.vehicle_type as veh_type_name')
                ->where('vehicles.user_id', '=', Auth::id())
                ->orderBy('vehicles.updated_at', 'DESC')
                ->get();

            return view('pages.user.MainPage', compact('vehicles', 'layout', 'title', 'description'));
        }

        if ($activeRole === 'agency') {
            $id = Auth::id();

            $agency = DB::table('users')->where('id', $id)->first();

            $managers = DB::table('users')
                ->where('agency_id', $id)
                ->where('role', 'manager')
                ->get();

            $users = DB::table('users')
                ->where('agency_id', $id)
                ->where('role', 'user')
                ->get();

            return view('pages.agency.index', compact('agency', 'managers', 'users', 'layout', 'title', 'description'));
        }

        return view('pages.local.home', compact('layout', 'title', 'description'));
    }

    public function coming_soon()
    {
        return view('pages.local.ComingSoon');
    }
}