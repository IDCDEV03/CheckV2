@php
  $baseRole = session('base_role');
    $activeRole = active_role();
@endphp
<style>
.card-hover {
    transition: all 0.2s ease-in-out;
}

.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}
</style>
@section('title', 'ระบบปฏิบัติการพนักงานขับรถราชการ')
@section('description', 'ID Drives')
@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <div class="social-dash-wrap">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <label class="fs-20 fw-bold text-dark breadcrumb-title">
                            @auth
                                {{ Auth::user()->name }}
                            @endauth

                        </label>


                    </div>
                </div>
            </div>



            <div class="row">
                <!-- รายการรถ -->
                <div class="col-md-6 mb-4">
                    <a href="https://kstplus.iddrives.co.th/" target="_blank" class="text-decoration-none">
                        <div class="card shadow-sm h-100 card-hover" style="border: 2px solid 	#2980B9; background-color: #D6EBFA;">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <img src="{{ asset('kst_plus.png') }}" alt="" height="60px">
                                </div>
                                <p class="fs-20 fw-bold card-title">KST PLUS</p>
                                <p class="card-text text-muted">สื่อคู่มือการใช้รถราชการ</p>
                            </div>
                        </div>
                    </a>
                </div>

                @if ($baseRole === 'agency' && Auth::user()->can_switch && $activeRole === 'agency')
                    <!-- รายการช่างตรวจรถ -->
                    <div class="col-md-6 mb-4">
                        <form action="{{ route('role.switch.user') }}" method="POST" class="h-100">
                            @csrf

                            <button type="submit" class="w-100 border-0 p-0 text-start bg-transparent">
                                <div class="card shadow-sm h-100 card-hover"
                                    style="border: 2px solid #F1C40F; background-color: #FFF9D6; cursor: pointer;">

                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <img src="{{ asset('inspector.png') }}" alt="" width="70px">
                                        </div>
                                        <p class="fs-20 fw-bold card-title mb-1">
                                            ระบบปฏิบัติการผู้ใช้งาน
                                        </p>
                                        <p class="card-text text-muted mb-2">
                                            สำหรับเจ้าหน้าที่ปฏิบัติงานตรวจรถ
                                        </p>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </div>
                @endif

            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-default mb-4 border border-primary">
                                        <div class="card-header">
                                            <p class="mb-0 fs-20 fw-bold">ประเภทผู้ใช้ หัวหน้า</p>
                                            <a href="{{ route('agency.create_account', ['role' => 'manager']) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-user-plus me-1"></i> เพิ่มหัวหน้า
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            @if ($managers->isEmpty())
                                                <p class="text-muted">ไม่มีหัวหน้าในหน่วยงานนี้</p>
                                            @else
                                                <table class="table table-bordered table-hover">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>ชื่อ</th>
                                                            <th>ลายเซ็น</th>
                                                            <th>จัดการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($managers as $index => $manager)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $manager->prefix }} {{ $manager->name }}
                                                                    {{ $manager->lastname }}
                                                                </td>
                                                                <td>
                                                                    @if ($manager->signature_image)
                                                                        <span class="text-success"> <i
                                                                                class="fas fa-check"></i></span>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>

                                                                    <div class="btn-group dm-button-group btn-group-normal my-2"
                                                                        role="group">
                                                                        <a href="#"
                                                                            class="btn  btn-xs btn-outline-warning">แก้ไข</a>

                                                                        <form
                                                                            action="{{ route('admin.member.destroy', $manager->id) }}"
                                                                            method="POST" class="d-inline delete-form">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                class="btn btn-xs btn-outline-danger btn-delete">
                                                                                ลบ
                                                                            </button>
                                                                        </form>

                                                                    </div>


                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif


                                        </div>
                                    </div>


                                </div>


                                {{-- User --}}
                                <div class="col-md-6">
                                    <div class="card card-default mb-25 border border-info">
                                        <div class="card-header">
                                            <p class="fs-20 mb-0 fw-bold">ประเภทผู้ใช้ เจ้าหน้าที่</p>
                                            <a href="{{ route('agency.create_account', ['role' => 'user']) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-user-plus me-1"></i> เพิ่มเจ้าหน้าที่
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            @if ($users->isEmpty())
                                                <p class="text-muted">ไม่มีเจ้าหน้าที่ในหน่วยงานนี้</p>
                                            @else
                                                <table class="table table-bordered table-hover">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>ชื่อ</th>
                                                            <th>ลายเซ็น</th>
                                                            <th>จัดการ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($users as $index => $user)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $user->prefix }} {{ $user->name }}
                                                                    {{ $user->lastname }}</td>
                                                                <td>
                                                                    @if ($user->signature_image)
                                                                        <span class="text-success"> <i
                                                                                class="fas fa-check"></i></span>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>

                                                                    <div class="btn-group dm-button-group btn-group-normal my-2"
                                                                        role="group">
                                                                        <a href="#"
                                                                            class="btn  btn-xs btn-outline-warning">แก้ไข</a>

                                                                        <form action="#" method="POST"
                                                                            class="d-inline delete-form">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                class="btn btn-xs btn-outline-danger btn-delete">
                                                                                ลบ
                                                                            </button>
                                                                        </form>

                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
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

