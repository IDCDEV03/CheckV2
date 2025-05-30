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

    public function profile()
    {
        $user = Auth::user();
        return view('pages.user.UserProfile',compact('user'));
    }

    public function veh_regis()
    {
        return view('pages.user.VehiclesRegister');
    }

    public function chk_list()
    {
        $user_id = Auth::user()->id;
        $record = DB::table('check_records')
            ->join('vehicle_types', 'check_records.vehicle_type', '=', 'vehicle_types.id')
            ->select('check_records.plate', 'check_records.province', 'check_records.created_at', 'vehicle_types.vehicle_type', 'check_records.record_id')
            ->where('check_records.user_id', '=', $user_id)
            ->orderBy('check_records.created_at', 'DESC')
            ->get();

        return view('pages.user.ChkList', compact('record'));
    }

    public function start_check($id)
    {
        $forms = DB::table('forms')
            ->where('form_id', '=', $id)
            ->first();

        $car_type = DB::table('vehicle_types')
            ->select('id', 'vehicle_type')
            ->orderBy('id', 'ASC')
            ->get();

        $province = DB::table('provinces')
            ->select('id', 'name_th')
            ->orderBy('name_th', 'ASC')
            ->get();

        return view('pages.user.ChkStart', compact('forms', 'car_type', 'province'));
    }

    public function chk_insert_step1(Request $request)
    {
        $provinces = $request->province;
        $car_type = $request->vehicle_type;

        if ($provinces == '0') {
            return redirect()->back()->with('error', 'กรุณาเลือกจังหวัด');
        }

        if ($car_type == '0') {
            return redirect()->back()->with('error', 'กรุณาเลือกประเภทรถ');
        }

        $request->validate(
            [
                'vehicle_image' => 'required|image|max:5048',
            ],
            [
                'vehicle_image.required' => 'กรุณาอัพโหลดภาพถ่ายรถ',
            ]
        );

        $rawInput = $request->input('plate');
        $cleanPlate = str_replace(' ', '', $rawInput); //ตัดช่องว่างออก

        // upload image
        $upload_location = 'upload/';
        $file = $request->file('vehicle_image');
        $extension = $file->getClientOriginalExtension();
        $newName = $cleanPlate . '_' . Carbon::now()->format('Ymd_His') . '.' . $extension;
        $file->move($upload_location, $newName);
        $fileName = $upload_location . $newName;


        $record_id = 'REC-' . Str::upper(Str::random(8));



        DB::table('check_records')->insert([
            'user_id' => Auth::id(),
            'form_id' => $request->form_id,
            'record_id' => $record_id,
            'plate' => $cleanPlate,
            'province' => $request->province,
            'vehicle_type' => $request->vehicle_type,
            'tax_exp' => $request->tax_exp,
            'vehicle_image' => $fileName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $firstCategory = DB::table('check_categories')
            ->where('form_id', $request->form_id)
            ->orderBy('cates_no')
            ->first();

        return redirect()->route('user.chk_step2', ['rec' => $record_id, 'cats' => $firstCategory->category_id]);
    }

    public function chk_step2($rec, $cats)
    {
        $forms = DB::table('check_categories')
            ->join('forms', 'check_categories.form_id', '=', 'forms.form_id')
            ->select('forms.form_name')
            ->where('check_categories.category_id', '=', $cats)
            ->first();

        $record = DB::table('check_records')->where('record_id', $rec)->first();
        $category = DB::table('check_categories')->where('category_id', $cats)->first();
        $items = DB::table('check_items')
            ->where('category_id', $category->category_id)->get();

        return view('pages.user.ChkStep2', compact('record', 'category', 'items', 'forms'));
    }

    public function chk_insert_step2(Request $request, $record_id, $category_id)
    {

        foreach ($request->item_result as $item_id => $value) {
            DB::table('check_records_result')->insert([
                'user_id' => Auth::id(),
                'record_id' => $record_id,
                'item_id' => $item_id,
                'result_value' => $value,
                'user_comment' => $request->user_comment[$item_id] ?? null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($request->hasFile("item_images.$item_id")) {
                foreach ($request->file("item_images.$item_id") as $image) {
                    $imagePath = 'upload/';
                    $newname = $item_id . '_' . $image->getClientOriginalName();
                    $image->move($imagePath, $newname);
                    $fileName = $imagePath . $newname;

                    DB::table('check_result_images')->insert([
                        'record_id' => $record_id,
                        'item_id' => $item_id,
                        'image_path' => $fileName,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }

        //หมวดถัดไป
        $current = DB::table('check_categories')->where('category_id', $category_id)->first();
        $next = DB::table('check_categories')
            ->where('form_id', $current->form_id)
            ->where('cates_no', '>', $current->cates_no)
            ->orderBy('cates_no')
            ->first();

        if ($next) {
            return redirect()->route('user.chk_step2', ['rec' => $record_id, 'cats' => $next->category_id]);
        }
        return redirect()->route('user.chk_result', ['record_id' => $record_id])->with('success', 'บันทึกสำเร็จ');
    }

    public function chk_result($record_id)
    {
        $record = DB::table('check_records')->where('record_id', $record_id)->first();

        $forms = DB::table('forms')
            ->select('forms.form_name')
            ->where('form_id', '=', $record->form_id)
            ->first();

        $categories = DB::table('check_categories')
            ->where('form_id', $record->form_id)
            ->orderBy('cates_no')
            ->get();

        $results = DB::table('check_records_result')
            ->join('check_items', 'check_records_result.item_id', '=', 'check_items.id')
            ->where('record_id', $record_id)
            ->select('check_items.category_id', 'check_items.item_name', 'check_records_result.item_id', 'result_value', 'user_comment')
            ->get()
            ->groupBy('category_id');

        $images = DB::table('check_result_images')
            ->where('record_id', $record_id)
            ->get()
            ->groupBy('item_id');

        return view('pages.user.ChkResult', compact('record', 'results', 'forms', 'categories','images'));
    }
}
