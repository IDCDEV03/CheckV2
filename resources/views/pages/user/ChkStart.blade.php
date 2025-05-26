@section('title', 'ระบบ E-Checker')
@section('description', 'ID Drives')
@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <div class="social-dash-wrap">
           
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class=" alert alert-primary " role="alert">
                        <div class="alert-content">
                            <span class="fs-20 fw-bold"> {{$forms->form_name}} </span>
                        </div>
                    </div>

                    <div class="card mb-25">
                        <div class="card-body">

 @include('partials._steps', ['currentStep' => 1])

 <form action="#" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>ทะเบียนรถ</label>
            <input type="text" name="plate" class="form-control" maxlength="10" required>
        </div>

        <div class="mb-3">
            <label>จังหวัด</label>
            <input type="text" name="province" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>ประเภทรถ</label>
            <input type="text" name="vehicle_type" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>วันหมดอายุภาษี</label>
            <input type="date" name="tax_exp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>ภาพถ่ายรถ</label>
            <input type="file" name="vehicle_image" class="form-control" accept="image/*" required>
        </div>

      <div class="border-top my-3"></div>

        <button type="submit" class="btn btn-block btn-secondary">เริ่มการตรวจ <i class="fas fa-arrow-right"></i></button>
    </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
