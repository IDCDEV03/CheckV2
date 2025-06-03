@section('title', 'ระบบ E-Checker')
@section('description', 'ID Drives')
@extends('layout.app')
@section('content')
    <style>
        .fixed-table {
            table-layout: fixed;
            width: 100%;
        }

        .fixed-table th,
        .fixed-table td {
            word-wrap: break-word;
            vertical-align: middle;
        }

        .fixed-table th:nth-child(1),
        .fixed-table td:nth-child(1) {
            width: 40%;
        }

        .fixed-table th:nth-child(2),
        .fixed-table td:nth-child(2) {
            width: 30%;
        }

        .fixed-table th:nth-child(3),
        .fixed-table td:nth-child(3) {
            width: 30%;
        }
    </style>

    <div class="container-fluid">
        <div class="social-dash-wrap">

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class=" alert alert-primary " role="alert">
                        <div class="alert-content">
                            <span class="fs-20 fw-bold"> {{ $forms->form_name }} </span>
                        </div>
                    </div>

                    <div class=" alert alert-success " role="alert">
                        <div class="alert-content">
                            <span class="fs-20 fw-bold">สรุปผลการตรวจ</span>
                        </div>
                    </div>

                    <div class="card mb-25">
                        <div class="card-body">

                            @php
                                $userdata = DB::table('users')
                                    ->where('id', $record->chk_user)
                                    ->select('users.prefix', 'users.name', 'users.lastname')
                                    ->first();

                                $fullname = $userdata->prefix . $userdata->name . ' ' . $userdata->lastname;
                            @endphp
                            
                            @if (!empty($agent_name->logo_agency))
                                <table class="table table-borderless">
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <img src="{{ asset($agent_name->logo_agency) }}" alt="" width="150px">
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            <table class="table table-bordered">
                                <tr>
                                    <td class="fw-bold">ทะเบียนรถ</td>
                                    <td>{{ $record->plate }} {{ $record->province }}</td>
                                    <td class="fw-bold">แบบฟอร์มตรวจ</td>
                                    <td>{{ $forms->form_name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">ประเภทรถ</td>
                                    <td>{{ $record->veh_type_name }}</td>
                                    <td class="fw-bold">วันที่/เวลาที่ตรวจในระบบ</td>
                                    <td>{{ thai_datetime($record->date_check) }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fw-bold">ตรวจโดย</span>
                                    </td>
                                    <td>
                                        {{ $fullname }}
                                    </td>
                                    <td class="fw-bold">สังกัด</td>
                                    <td> {{ $agent_name->name }} </td>
                                </tr>

                            </table>

                            <div class="my-4 text-center">

                            </div>

                            @foreach ($categories as $cat)
                                <span class="fs-18 fw-bold mt-4">{{ $cat->cates_no }}. {{ $cat->chk_cats_name }}</span>

                                <table class="table table-bordered fixed-table mt-2">
                                    <thead>
                                        <tr>
                                            <th>รายการ</th>
                                            <th>ผลตรวจ</th>
                                            <th>ความคิดเห็น</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results[$cat->category_id] ?? [] as $r)
                                            <tr>
                                                <td class="text-left">{{ $r->item_name }}</td>
                                                <td>
                                                    @if ($r->result_value == '1')
                                                        ปกติ
                                                    @elseif($r->result_value == '0')
                                                        <span class="text-danger">ไม่สามารถใช้งานได้</span>
                                                    @elseif($r->result_value == '2')
                                                        <span class="text-secondary"> ไม่ปกติ แต่ยังสามารถใช้งานได้ </span>
                                                    @endif
                                                </td>
                                                <td>{{ $r->user_comment }}</td>
                                            </tr>
                                            @if (isset($images[$r->item_id]))
                                                <tr>
                                                    <td colspan="3" class="text-center">
                                                        @foreach ($images[$r->item_id] as $img)
                                                            <img src="{{ asset($img->image_path) }}" class="img-thumbnail"
                                                                width="200px" alt="">
                                                        @endforeach
                                                    </td>
                                            @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach

                            <div class="border-top my-3"></div>

                            <a href="{{ route('user.create_repair', ['record_id' => $record->record_id]) }}"
                                class="btn btn-block btn-secondary fs-20"><i class="far fa-file-alt"></i>
                                สร้างบันทึกแจ้งข้อบกพร่อง</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-fluid" alt="Preview">
                    </div>
                </div>
            </div>
        </div>

        <!-- Script -->
        <script>
            function showImage(url) {
                const modalImg = document.getElementById('modalImage');
                modalImg.src = url;
                const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                modal.show();
            }
        </script>

    @endsection
