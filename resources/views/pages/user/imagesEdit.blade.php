@section('title', 'ระบบปฏิบัติการพนักงานขับรถราชการ')
@section('description', 'ID Drives')
@extends('layout.app')
@section('content')

    <div class="container-fluid">
        <div class="social-dash-wrap">

            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-4 mb-25">
                                <div class="card-header">
                                    <span class="fs-20 mb-0">รายการภาพการตรวจรถ ( {{ $car_detail->plate }}
                                        {{ $car_detail->province }} )
                                        วันที่ตรวจ {{ thai_datetime($car_detail->updated_at) }}

                                    </span>
                                </div>
                                <div class="card-body">
                                    <p class="fs-18 fw-bold">ข้อตรวจ : {{ $chk_item->item_name }}</p>

                                    <div class="table-responsive">
                                        <table class="table table-default table-bordered mb-0" id="table-one">
                                            <thead>
                                                <tr>
                                                    <th class="text-sm fw-bold">#</th>
                                                    <th class="text-sm fw-bold">ภาพ</th>
                                                    <th>จัดการ</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($image as $item)
                                                    <tr>

                                                        <td></td>
                                                        <td>
                                                            <img src="{{ asset($item->image_path) }}" width="200px"
                                                                alt="" class="img-thumbnail">
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group"
                                                                aria-label="Image Actions">
                                                                <a href="#" class="btn btn-outline-primary">
                                                                    <i class="fas fa-edit"></i> เปลี่ยนภาพ
                                                                </a>
                                                                <a href="#" class="btn btn-outline-danger">
                                                                    <i class="fas fa-trash-alt"></i> ลบ
                                                                </a>
                                                            </div>
                                                        </td>



                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- DataTables  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table-one').DataTable({
                responsive: true,
                pageLength: 25,
                language: {
                    search: "ค้นหา:",
                    lengthMenu: "แสดง _MENU_ รายการ",
                    info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    paginate: {
                        next: "ถัดไป",
                        previous: "ก่อนหน้า"
                    }
                }
            });
        });
    </script>
@endpush
