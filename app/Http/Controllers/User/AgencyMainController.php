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

class AgencyMainController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:agency']);
    }

    public function main_page()
    {
        $list_post = DB::table('announcements')
            ->join('users', 'announcements.user_id', '=', 'users.id')
            ->select('users.name', 'users.role', 'users.id', 'announcements.id as post_id', 'announcements.title', 'announcements.description', 'announcements.file_upload', 'announcements.updated_at', 'announcements.created_at')
            ->orderBy('announcements.updated_at', 'DESC')
            ->get();

        return view('pages.local.announce', compact('list_post'));
    }

    public function form_list()
    {

        $data = DB::table('forms')
        ->orderBy('forms.id','ASC')
        ->get();

        return view('pages.agency.FormList',compact('data'));
    }

    

    public function form_create()
    {

        $car_type = DB::table('vehicle_types')->get();

        return view('pages.agency.FormCreate', compact('car_type'));
    }

    public function form_insert(Request $request)
    {
        $car_id = Str::upper(Str::random(8));

        if ($request->form_category != "") {
            DB::table('forms')
                ->insert([
                    'user_id'       => Auth::user()->id,
                    'form_id'       => $car_id,
                    'form_code'     => $request->input('form_code'),
                    'form_name'     => $request->form_name,
                    'form_category' => $request->form_category,
                    'form_status'   => '1',
                    'created_at'    =>  Carbon::now(),
                    'updated_at'    =>  Carbon::now()
                ]);

            return redirect()->route('agency.form_list')->with('success', 'บันทึกข้อมูลสำเร็จ');
        } else {
            return redirect()->back()->with('error', 'กรุณาเลือกประเภทฟอร์ม');
        }
    }
}
