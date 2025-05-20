<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Enums\Role;

class PageController extends Controller
{
    public function home()
    {
        $user = Auth::user();
         $role = $user->role;
     
         $layout = match ($role) {
            Role::Admin => 'layout.LayoutAdmin',
            Role::Manager => 'layout.manager',
            Role::Agency => 'layout.agency',
            Role::User => 'layout.app',
        };

         $title = match ($role) {
            Role::Admin => 'ผู้ดูแลระบบ',
            Role::Manager => 'แดชบอร์ดผู้จัดการ',
            Role::Agency => 'แดชบอร์ดหน่วยงาน',
            Role::User => 'แดชบอร์ดผู้ใช้งานทั่วไป',
        };

         $description = match ($role) {
            Role::Admin => 'ผู้ดูแลระบบ',
            Role::Manager => 'แดชบอร์ดผู้จัดการ',
            Role::Agency => 'แดชบอร์ดหน่วยงาน',
            Role::User => 'แดชบอร์ดผู้ใช้งานทั่วไป',
        };

        return view('pages.local.home', compact('layout','title','description'));
    }
}
