<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ManageUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function createAgency()
    {
        return view('pages.admin.create_agency');
    }

    public function insert_agency(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
            'logo' => 'nullable|image|max:10240', // 10MB
        ]);

        $upload_location = 'logo/';

        $fileName = null;

        if ($request->hasFile('logo')) {

            $file = $request->file('logo');

            $extension = $file->getClientOriginalExtension();
            $newName = Carbon::now()->format('Ymd_His') . '_' . auth()->id() . '.' . $extension;
            $file->move($upload_location, $newName);
            $fileName = $upload_location.$newName;
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_phone' => $request->phone,
            'logo_agency' => $fileName,
            'role' => 'agency',
            'created_at' =>  Carbon::now(),
            'updated_at' =>  Carbon::now(),
        ];

        DB::table('users')->insert($data);

        return redirect()->route('admin.agency_list')->with('success', 'สร้างหน่วยงานเรียบร้อยแล้ว');
    }

    public function Agency_list()
    {

        $agencies = DB::table('users')
        ->where('role', 'agency')
        ->orderByDesc('created_at')
        ->get();

        return view('pages.admin.AgencyList',compact('agencies'));
    }
}
