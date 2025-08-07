@section('title', 'E-Checker System')
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
                            <span class="fs-20 fw-bold">ระบบตรวจเช็ครถประจำวันก่อนการใช้งาน / Pre-Drive Inspection System</span>
                        </div>
                    </div>

                    <div class="card mb-25">
                        <div class="card-header d-flex justify-content-end align-items-center">

                            <small class="text-muted" id="live-clock">

                        </div>
                        <div class="card-body">

                            @if (session('error'))
                                <div class="alert alert-danger fs-20 fw-bold">{{ session('error') }}</div>
                            @endif

                            <form action="{{route('guest.insert1')}}" method="POST">
                                @csrf
<input type="hidden" name="car_type" value="6">
                                <div class="form-group row">
                                    <div class="col-sm-3 d-flex aling-items-center">
                                        <label for="inputName"
                                            class="col-form-label color-dark fs-18 fw-bold align-center">License plate</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control ih-medium ip-light radius-xs b-light px-15"
                                          name="plate"  placeholder="Exemple : กค3432 กรุงเทพมหานคร" autofocus required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-3 d-flex aling-items-center">
                                        <label for="inputName"
                                            class="col-form-label color-dark fs-18 fw-bold align-center">Form:</label>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="radio-theme-default custom-radio ">
                                            <input class="radio" type="radio" name="form_id" value="JU4Z78JD" id="form_id" checked>
                                            <label for="form_id">
                                                <span class="radio-text  fs-16">Ambulance Check Form Before Use</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="border-top my-3"></div>

                                <button type="submit" class="btn btn-secondary btn-block fs-20">เริ่มการตรวจ / Start Check &nbsp;<i
                                        class="fas fa-arrow-right"></i> </button>
                            </form>

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
