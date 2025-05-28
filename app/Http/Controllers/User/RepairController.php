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

class RepairController extends Controller
{


    public function create_repair($record_id)
    {

        if (!in_array(auth()->user()->role, [Role::User, Role::Manager, Role::Agency])) {
            abort(403);
        }

        $record = DB::table('check_records')
            ->where('record_id', '=', $record_id)
            ->first();

        $problem_items = DB::table('check_records_result')
            ->join('check_items', 'check_records_result.item_id', '=', 'check_items.id')
            ->where('check_records_result.record_id', $record_id)
            ->whereIn('check_records_result.result_value', [0, 2])
            ->select('check_items.id as item_id', 'check_items.item_name', 'check_records_result.result_value', 'check_records_result.user_comment')
            ->get();


        return view('pages.local.CreateRepair', compact('record', 'problem_items'));
    }
}
