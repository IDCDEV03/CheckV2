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
            ->orderBy('forms.id', 'ASC')
            ->get();

        return view('pages.agency.FormList', compact('data'));
    }

    public function form_create()
    {
        $car_type = DB::table('vehicle_types')->get();
        return view('pages.agency.FormCreate', compact('car_type'));
    }

    public function form_insert(Request $request)
    {
        $form_id = Str::upper(Str::random(8));

        if ($request->form_category != "") {
            DB::table('forms')
                ->insert([
                    'user_id'       => Auth::user()->id,
                    'form_id'       => $form_id,
                    'form_code'     => $request->input('form_code'),
                    'form_name'     => $request->form_name,
                    'form_category' => $request->form_category,
                    'form_status'   => '1',
                    'created_at'    =>  Carbon::now(),
                    'updated_at'    =>  Carbon::now()
                ]);

            return redirect()->route('agency.create_cates', ['id' => $form_id])->with('success', 'บันทึกข้อมูลสำเร็จ');
        } else {
            return redirect()->back()->with('error', 'กรุณาเลือกประเภทฟอร์ม');
        }
    }

    public function cates_list($form_id)
    {
        $data = DB::table('check_categories')
            ->where('form_id', '=', $form_id)
            ->orderBy('cates_no', 'ASC')
            ->get();

        $form_name = DB::table('forms')
            ->where('form_id', '=', $form_id)
            ->first();

        return view('pages.agency.CatesList', ['form_id' => $form_id], compact('data', 'form_name'));
    }

    public function cates_detail($cates_id)
    {
        $cates_data = DB::table('check_categories')
            ->join('forms', 'check_categories.form_id', '=', 'forms.form_id')
            ->select('forms.form_name','forms.form_id', 'check_categories.category_id', 'check_categories.chk_cats_name')
            ->where('check_categories.category_id', '=', $cates_id)
            ->first();

        return view('pages.agency.CatesDetail', ['cates_id' => $cates_id], compact('cates_data'));
    }

    public function create_cates($id)
    {
        $chk_cates = DB::table('forms')
            ->where('form_id', '=', $id)
            ->first();

        return view('pages.agency.Cates_Create', compact('chk_cates'));
    }

    public function insert_cates(Request $request, $id)
    {
        foreach ($request->chk_cats_name as $index => $name) {
            DB::table('check_categories')->insert([
                'user_id' => Auth::id(),
                'form_id' => $id,
                'cates_no' => $request->order_no[$index] ?? ($index + 1),
                'category_id' => 'CAT-' . Carbon::now()->format('YmdHi') . '-' . $index + 1,
                'chk_cats_name' => $name,
                'chk_detail' => $request->chk_detail[$index] ?? null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return redirect()->route('agency.cates_list', ['form_id' => $id])->with('success', 'บันทึกหมวดหมู่เรียบร้อยแล้ว');
    }

    public function item_create($id)
    {
        $cates_data = DB::table('check_categories')
            ->join('forms', 'check_categories.form_id', '=', 'forms.form_id')
            ->select('forms.form_name', 'check_categories.category_id', 'check_categories.chk_cats_name')
            ->where('check_categories.category_id', '=', $id)
            ->first();

        return view('pages.agency.itemCreate', ['id' => $id], compact('cates_data'));
    }

    public function item_insert(Request $request)
    {
       
        foreach ($request->item_name as $index => $name) {
             $fileName = null;

            $list = $index + 1;
            $item_id = 'CH_'.$list.'_'.Str::upper(Str::random(8));

            if ($request->hasFile('item_image.' . $index)) {
            $imagePath = 'upload/';
            $file = $request->file('item_image.' . $index);             
            $extension = $file->getClientOriginalExtension();
            $newName = 'item_' . $item_id . '_' . $list . '.' . $extension;
            $file->move($imagePath, $newName);
            $fileName = "public/".$imagePath.$newName;
            }
         

            DB::table('check_items')->insert([
                'user_id' => Auth::id(),
                'category_id' => $request->cate_id,
                'item_id' => $item_id, 
                'item_no' => $index + 1,
                'item_name' => $name,
                'item_description' => $request->item_description[$index] ?? null,
                'item_type' => $request->item_type[$index],
                'item_image' => $fileName, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        return redirect()->route('agency.cates_detail', ['cates_id' => $request->cate_id])->with('success', 'บันทึกข้อตรวจเรียบร้อยแล้ว');
    }
}
