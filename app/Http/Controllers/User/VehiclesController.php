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
            ->join('vehicle_types','vehicles.veh_type','=','vehicle_types.id')
            ->select('vehicles.*', 'vehicle_types.vehicle_type as veh_type_name')
            ->where('vehicles.veh_id','=',$id)
            ->first();

          $record = DB::table('chk_records')
        ->join('vehicles','chk_records.veh_id','=','vehicles.veh_id')
        ->join('vehicle_types','vehicles.veh_type','=','vehicle_types.id')
        ->select('vehicles.*', 'vehicle_types.vehicle_type as veh_type_name','chk_records.created_at as date_check','chk_records.form_id','chk_records.record_id','chk_records.user_id as chk_user','chk_records.agency_id as chk_agent')
        ->where('chk_records.veh_id', $id)->first();

        return view('pages.local.VehiclesDetail', ['id' => $id], compact('vehicle'));
    }
}
