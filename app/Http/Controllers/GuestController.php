<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class GuestController extends Controller
{
     public function guest_chk()
    {

        return view('pages.guest.Chk_Start');
    }

    public function chk_step1(Request $request)
    {
        $record_id = 'PUB-' . Str::upper(Str::random(10));

        DB::table('public_records')->insert([
            'record_id' => $record_id,
            'form_id' => $request->form_id,
            'license_plate' => $request->plate,
            'car_type' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

           $firstCategory = DB::table('check_categories')
            ->where('form_id', $request->form_id)
            ->orderBy('cates_no')
            ->first();

        return redirect()->route('guest.chk_step2', ['rec' => $record_id, 'cats' => $firstCategory->category_id]);

    }

    public function guest_chk_step2 ($rec, $cats)
    {
$forms = DB::table('check_categories')
            ->join('forms', 'check_categories.form_id', '=', 'forms.form_id')
            ->select('forms.form_name')
            ->where('check_categories.category_id', '=', $cats)
            ->first();

        $record = DB::table('public_records')->where('record_id', $rec)->first();
        $category = DB::table('check_categories')->where('category_id', $cats)->first();

        $items = DB::table('check_items')
            ->where('category_id', $category->category_id)->get();

        return view('pages.guest.Chk_Step2', compact('record', 'category', 'items', 'forms'));
    }

    public function insert_step2(Request $request,$record_id, $category_id)
    {

         foreach ($request->item_result as $item_id => $value) {
            DB::table('public_record_results')->insert([          
                'record_id' => $record_id,
                'item_id' => $item_id,
                'result_value' => $value,
                'user_comment' => $request->user_comment[$item_id] ?? null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($request->hasFile("item_images.$item_id")) {
                foreach ($request->file("item_images.$item_id") as $image) {
                    $imagePath = 'upload/guest/';
                    $newname = $item_id . '_' . $image->getClientOriginalName();
                    $image->move($imagePath, $newname);
                    $fileName = $imagePath . $newname;

                    DB::table('public_result_images')->insert([
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
            return redirect()->route('guest.chk_step2', ['rec' => $record_id, 'cats' => $next->category_id]);
        }
        return redirect()->route('guest.chk_result', ['record_id' => $record_id])->with('success', 'บันทึกสำเร็จ');

    }

      public function chk_result($record_id)
    {
        $record = DB::table('public_records')       
            ->join('vehicle_types', 'public_records.car_type', '=', 'vehicle_types.id')
            ->select('vehicle_types.vehicle_type as veh_type_name', 'public_records.created_at as date_check', 'public_records.form_id', 'public_records.record_id','public_records.license_plate')
            ->where('public_records.record_id', $record_id)->first();


        $forms = DB::table('forms')
            ->select('forms.form_name')
            ->where('form_id', '=', $record->form_id)
            ->first();

        $categories = DB::table('check_categories')
            ->where('form_id', $record->form_id)
            ->orderBy('cates_no')
            ->get();

        $results = DB::table('public_record_results')
            ->join('check_items', 'public_record_results.item_id', '=', 'check_items.id')
            ->where('record_id', $record_id)
            ->select('check_items.category_id', 'check_items.item_name', 'public_record_results.item_id', 'result_value', 'user_comment')
            ->get()
            ->groupBy('category_id');

        $images = DB::table('public_result_images')
            ->where('record_id', $record_id)
            ->get()
            ->groupBy('item_id');

            $item_chk = DB::table('public_record_results')
            ->select('record_id', 'item_id', DB::raw('COUNT(result_value) as count'))
            ->where('record_id', $record_id)
            ->whereIn('result_value', [0, 2])
            ->groupBy('record_id', 'item_id')
            ->get();

        return view('pages.guest.Chk_Result', compact('record', 'results', 'forms', 'categories', 'images','item_chk'));
    }
}
