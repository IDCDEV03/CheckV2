@section('title', 'ระบบ E-Checker')
@section('description', 'ID Drives')
@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <div class="social-dash-wrap">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">รายละเอียดหมวดหมู่</h4>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class=" alert alert-info " role="alert">
                        <div class="alert-content">
                            <span class="fs-20 fw-bold">แบบฟอร์ม : {{ $cates_data->form_name }}</span>
                            <br>
                            <span class="fs-20 fw-bold">หมวดหมู่ : {{ $cates_data->chk_cats_name }} </span>
                        </div>
                    </div>

                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="dm-button-list d-flex flex-wrap">
                                  <a href="{{route('agency.cates_list',['form_id'=>$cates_data->form_id])}}" class="mx-2 btn btn-success btn-default btn-squared btn-shadow-success ">
                                    กลับไปรายการหมวดหมู่
                                </a>

                                <a href="#" class="mx-2 btn btn-warning btn-default btn-squared btn-shadow-warning ">
                                    แก้ไขชื่อหมวดหมู่
                                </a>

                                <a href="{{route('agency.item_create',['id'=>request()->cates_id])}}" class="mx-2 btn btn-secondary btn-default btn-squared btn-shadow-secondary ">
                                    เพิ่มข้อตรวจ
                                </a>                             
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">

                            ****


                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
