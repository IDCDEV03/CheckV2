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

class VehiclesController extends Controller
{
  public function veh_detail($id)
  {
    $vehicle = DB::table('vehicles')
      ->join('vehicle_types', 'vehicles.veh_type', '=', 'vehicle_types.id')
      ->select('vehicles.*', 'vehicle_types.vehicle_type as veh_type_name')
      ->where('vehicles.veh_id', '=', $id)
      ->first();

    $record = DB::table('chk_records')
      ->join('forms', 'forms.form_id', '=', 'chk_records.form_id')
      ->select('chk_records.created_at as date_check', 'chk_records.form_id', 'chk_records.record_id', 'forms.form_name', 'chk_records.veh_id')
      ->orderBy('chk_records.created_at', 'DESC')
      ->where('chk_records.veh_id', $id)->get();

    return view('pages.local.VehiclesDetail', ['id' => $id], compact('vehicle', 'record'));
  }

  public function Report_Result($rec)
  {
    // 1. ดึงข้อมูลการตรวจรถ + ยานพาหนะ
    $record = DB::table('chk_records')
      ->join('vehicles', 'chk_records.veh_id', '=', 'vehicles.veh_id')
      ->join('vehicle_types', 'vehicles.veh_type', '=', 'vehicle_types.id')
      ->select(
        'vehicles.*',
        'vehicle_types.vehicle_type as veh_type_name',
        'chk_records.created_at as date_check',
        'chk_records.form_id',
        'chk_records.record_id',
        'chk_records.user_id as chk_user',
        'chk_records.agency_id as chk_agent'
      )
      ->where('chk_records.record_id', $rec)
      ->first();

    if (!$record) {
      return back()->with('error', 'ไม่พบข้อมูลการตรวจรถที่ต้องการ');
    }

    // 2. ดึงชื่อหน่วยงานที่ตรวจ (agent)
    $agent_name = DB::table('users')
      ->where('id', $record->chk_agent)
      ->first();

    // 3. ดึงชื่อแบบฟอร์ม
    $forms = DB::table('forms')
      ->select('form_name')
      ->where('form_id', $record->form_id)
      ->first();

    // 4. ดึงรายการหมวดหมู่ที่เกี่ยวข้องกับแบบฟอร์ม
    $categories = DB::table('check_categories')
      ->where('form_id', $record->form_id)
      ->orderBy('cates_no')
      ->get();

    // 5. ดึงผลการตรวจแยกตามหมวด
    $results = DB::table('check_records_result')
      ->join('check_items', 'check_records_result.item_id', '=', 'check_items.id')
      ->where('record_id', $rec)
      ->select(
        'check_items.category_id',
        'check_items.item_name',
        'check_records_result.item_id',
        'result_value',
        'user_comment'
      )
      ->get()
      ->groupBy('category_id');

    // 6. ดึงภาพที่แนบในการตรวจ
    $images = DB::table('check_result_images')
      ->where('record_id', $rec)
      ->get()
      ->groupBy('item_id');

    

    return view('pages.local.ReportResult', compact('agent_name', 'record', 'results', 'forms', 'categories', 'images'));
  }

  public function repair_notice(){
    return view('pages.local.RepairNoice');
  }


  public function edit_images($record_id,$id)
  {
     $image = DB::table('check_result_images')   
    ->where('check_result_images.record_id', $record_id)
    ->where('check_result_images.item_id', $id)
    ->select(
        'check_result_images.image_path',  
        'check_result_images.record_id',
    )
    ->get();

    $chk_item = DB::table('check_items')
    ->where('id',$id)
    ->first();

    $car_detail = DB::table('chk_records')
      ->join('vehicles', 'chk_records.veh_id', '=', 'vehicles.veh_id')
    ->where('chk_records.record_id', $record_id)
    ->select(
       'vehicles.plate',
        'vehicles.province',
        'chk_records.updated_at'
    )
    ->first();

     return view('pages.user.imagesEdit',compact('image','car_detail','chk_item'));
  }

}
