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

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        return view('pages.admin.index');
    }

    public function AnnouncementPage()
    {
        $list_post = DB::table('announcements')
        ->join('users','announcements.user_id','=','users.id')
        ->select('users.name','users.role','users.id','announcements.id as post_id','announcements.title','announcements.description','announcements.file_upload','announcements.updated_at')
        ->orderBy('announcements.updated_at','DESC')
        ->get();

        return view('pages.admin.announce',compact('list_post'));
    }

    public function create_announce()
    {
        return view('pages.admin.create_announce');
    }

    public function insert_post(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:200',
                'detail' => 'required|string',
                'file_upload' => 'nullable|file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png',
            ],
            [
                'title.required' => 'กรุณากรอกหัวข้อประกาศ',
                'detail.required' => 'กรุณากรอกเนื้อหาประกาศ',
                'file_upload.mimes' => 'ไฟล์ต้องเป็นประเภท PDF, DOC, DOCX, JPG หรือ PNG เท่านั้น',
                'file_upload.max' => 'ขนาดไฟล์ต้องไม่เกิน 5 MB',
            ]
        );

        $upload_location = 'upload/';

        $fileName = null;

        if ($request->hasFile('file_upload')) {

            $file = $request->file('file_upload');

            $extension = $file->getClientOriginalExtension();
            $newName = Carbon::now()->format('Ymd_His') . '_id' . auth()->id() . '.' . $extension;

            $file->move($upload_location,$newName);

            $fileName = $newName;
        }

        DB::table('announcements')->insert([
            'user_id'    => Auth::user()->id,
            'title'      => $request->input('title'),
            'description' => $request->input('detail'),
            'file_upload' => $fileName,
            'created_at' =>  Carbon::now(),
            'updated_at' =>  Carbon::now(),
        ]);

        return redirect()->route('admin.announce')->with('success', 'บันทึกสำเร็จ');
    }

    public function edit_post($id)
    {
        $announce = DB::table('announcements')
        ->where('id','=',$id)
        ->first();

        return view('pages.admin.edit_announce',compact('announce'));
    }

    public function update_post($id)
    {

    }

}
