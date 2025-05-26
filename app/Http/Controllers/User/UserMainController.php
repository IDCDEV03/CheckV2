<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Enums\Role;
use Illuminate\Support\Facades\File;

class UserMainController extends Controller
{
      public function __construct()
    {
        $this->middleware(['auth', 'role:user']);
    }

    public function start_check($id)
    {
         $forms = DB::table('forms')
            ->where('form_id','=',$id)
            ->first();

        return view('pages.user.ChkStart',compact('forms'));
    }
}
