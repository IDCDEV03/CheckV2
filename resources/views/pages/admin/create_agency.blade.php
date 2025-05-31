@section('title', 'ระบบปฏิบัติการพนักงานขับรถราชการ')
@section('description', 'ID Drives')
@extends('layout.LayoutAdmin')
@section('content')

    <div class="container-fluid">
        <div class="social-dash-wrap">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <span class="fs-24 fw-bold breadcrumb-title">สร้างหน่วยงาน</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-body">

                            <form action="{{route('admin.agency.insert')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">ชื่อหน่วยงาน<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">อีเมล (สำหรับใช้ Login เข้าสู่ระบบ) <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="เช่น example@gmail.com" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">รหัสผ่าน<span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">เบอร์โทรศัพท์ (ถ้ามี)</label>
                                    <input type="text" name="phone" id="phone"class="form-control"
                                        value="{{ old('phone') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="logo" class="form-label">โลโก้หน่วยงาน (ถ้ามี)</label>
                                    <input type="file" name="logo" id="logo"
                                        class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                                    <div class="text-muted fs-12 mt-2">ขนาดไฟล์ไม่เกิน 10MB</div>

                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- preview --}}
                                <div class="mt-3 mb-4">
                                    <img id="logo-preview" src="#" alt="Preview_img" class="img-thumbnail d-none"
                                        style="max-height: 150px;">
                                </div>


                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-1"></i> เพิ่มหน่วยงาน
                                </button>

                            </form>


                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('logo').addEventListener('change', function (event) {
        const input = event.target;
        const preview = document.getElementById('logo-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };

            reader.readAsDataURL(input.files[0]);
        }
    });
</script>
@endpush
