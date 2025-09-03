@section('title', 'ระบบ E-Checker')
@section('description', 'ID Drives')
@extends('layout.guest_app')
@section('content')
    <div class="container-fluid">

        <div class="my-4">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4 text-center">
                    <img src="{{ asset('logo/logo-id.png') }}" alt="Company Logo" class="img-fluid" style="max-height: 80px;">
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class=" alert alert-primary " role="alert">
                    <div class="alert-content">
                        <span class="fs-20 fw-bold">ระบบตรวจเช็ครถประจำวันก่อนการใช้งาน</span>
                    </div>
                </div>

                <div class="card mb-25">
                    <div class="card-header d-flex justify-content-end align-items-center">

                        <small class="text-muted" id="live-clock">

                    </div>
                    <div class="card-body">
 <div class="col-12">
                        <div class="row">
                            <!-- รายการบริษัทฯ -->
                            @foreach ($list_form as $data)
                                <div class="col-sm-4 mb-4">
                                    <a href="{{route('guest.page_step1',[$data->form_id])}}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100"
                                            style="border: 2px solid 	{{$data->main_color}}; background-color: {{$data->bg_color}};">
                                            <div class="card-body text-center">
                                                 <div class="mb-3">
                                    <img src="{{ asset($data->form_icon) }}" alt="" width="120px">
                                </div>
                                                <span class="fs-18 fw-bold card-title">{{ $data->form_name }}</span>
                                              
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
 </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function updateClock() {
            const now = new Date();

            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const year = now.getFullYear() + 543;

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const fullDateTime = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;

            document.getElementById('live-clock').textContent = fullDateTime;
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>
@endpush
