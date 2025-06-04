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
                            <span class="fs-20 fw-bold"> สร้างบันทึกแจ้งซ่อมยานพาหนะ </span>
                        </div>
                    </div>



                    <div class="card mb-25">
                        <div class="card-body">

                            <label class="mb-4 fs-24">เลขทะเบียน : {{ $record->plate }} {{ $record->province }} </label>

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
                                                    <input type="checkbox" name="repair_items[]"
                                                        value="{{ $item->item_id }}">
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

                                <div class="mb-3">
                                    <label for="title" class="form-label fw-bold">หัวข้อแจ้งซ่อม <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>



                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">รายละเอียดเพิ่มเติม</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="border-top my-3"></div>
                                <button type="submit" class="btn btn-secondary">
                                    บันทึกแจ้งซ่อม
                                </button>
                            </form>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
