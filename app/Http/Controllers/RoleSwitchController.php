<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Enums\Role;
use App\Models\User;

class RoleSwitchController extends Controller
{
    public function switchToUser(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'กรุณาเข้าสู่ระบบ');
        }

        $user = Auth::user();
       
        if ($user->role !== Role::Agency) {
            abort(403, 'เฉพาะบัญชีหน่วยงานเท่านั้นที่สามารถสลับเป็นผู้ใช้งานได้');
        }
        
       if (!$user->canSwitchToUserView()) {
            abort(403, 'บัญชีนี้ไม่มีสิทธิ์สลับไปยังโหมดผู้ใช้งาน');
        }

         session([
            'base_role'   => $user->role->value, // เก็บ role จริง
            'active_role' => Role::User->value,  // เปลี่ยนเป็น user
        ]);

        return redirect()
            ->route('local.home');
    }

    public function switchBackAgency(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'กรุณาเข้าสู่ระบบ');
        }

        $user = Auth::user();

        if ($user->role !== Role::Agency) {
            abort(403, 'เฉพาะบัญชีหน่วยงานเท่านั้นที่สามารถกลับสู่โหมดหน่วยงานได้');
        }

        session([
            'base_role'   => $user->role->value,
            'active_role' => Role::Agency->value,
        ]);

        return redirect()
            ->route('agency.index');
    }
}