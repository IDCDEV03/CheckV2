@section('title', 'ระบบปฏิบัติการพนักงานขับรถราชการ')
@section('description', 'ID Drives')
@extends('layout.app')
@section('content')

    <div class="container-fluid">
        <div class="social-dash-wrap">

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class=" alert alert-primary " role="alert">
                        <div class="alert-content">
                            <span class="fs-20 fw-bold"> บันทึกแจ้งข้อบกพร่องของยานพาหนะ ทะเบียนรถ : {{ $record->plate }}
                                {{ $record->province }}</span>
                        </div>
                    </div>

                    <div class="card mb-25">
                        <div class="card-body">

                            <p class="fs-18 fw-bold">เลือกรายการที่ต้องการแจ้ง</p>

                            <form action="#" method="POST">
                                @csrf

                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;">เลือก</th>
                                            <th>รายการบกพร่องจากการตรวจรถ</th>
                                            <th>สถานะ</th>
                                            <th>ความคิดเห็น</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($problem_items as $item)
                                            <tr>
                                                <td>
                                                    <div class="checkbox-theme-default custom-checkbox ">
                                                        <input class="checkbox" type="checkbox"
                                                            id="check-un{{ $item->item_id }}" name="repair_items[]"
                                                            value="{{ $item->item_id }}">
                                                        <label for="check-un{{ $item->item_id }}">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>{{ $item->item_name }}</td>
                                                <td>
                                                    @if ($item->result_value == 0)
                                                        ไม่สามารถใช้งานได้
                                                    @elseif ($item->result_value == 2)
                                                        ไม่ปกติ แต่สามารถใช้งานได้
                                                    @endif
                                                </td>
                                                <td>{{ $item->user_comment }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label fw-bold">เลขทะเบียน </label>
                                            <input type="text" name="plate" id="plate"
                                                value="{{ $record->plate }} {{ $record->province }}" class="form-control"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="car_brand" class="form-label fw-bold">ยี่ห้อรถ </label>
                                            <input type="text" name="car_brand" id="car_brand" class="form-control"
                                                value="{{ $record->veh_brand }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="car_brand" class="form-label fw-bold">เลขไมล์ที่แจ้งซ่อม <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" name="car_mile" id="car_mile" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">รายละเอียดเพิ่มเติม</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                                </div>

                                <div class="border-top my-3"></div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="car_brand" class="form-label fw-bold">ผู้ตรวจสอบ </label>
                                        <select name="select-alerts2" id="select-alerts2" class="form-control ">
                                            <option selected disabled>--เลือกผู้ตรวจสอบ--</option>
                                            @foreach ($manager_list as $manager)
                                                <option value="{{ $manager->id }}">
                                                    {{ $manager->prefix }} {{ $manager->name }} {{ $manager->lastname }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>


                                <div class="border-top my-3"></div>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-info fs-18"><i class="fas fa-search"></i> Preview เอกสาร</a>
                                    <button type="submit" class="btn btn-success fs-18">บันทึกแจ้งซ่อม</button>
                                </div>

                            </form>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
