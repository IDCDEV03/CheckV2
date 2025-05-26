@section('title', $title)
@section('description', $description)
@extends($layout)
@section('content')
    @php
        use App\Enums\Role;
        $role = Auth::user()->role;
    @endphp
    <div class="container-fluid">
        <div class="social-dash-wrap">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">หน้าหลัก</h4>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    @if ($role === Role::User)
                        <div class="row">
                            @foreach ($forms as $item)
                            <div class="col-md-6">
                                <div class="card p-4 h-100">
                                    <span class="fs-18 mb-3"><i class="fas fa-clipboard-check"></i>
                                    {{$item->form_name}} </span>
                                    <a href="{{route('user.chk_start',['id'=>$item->form_id])}}" class="btn btn-outline-primary">เริ่มการตรวจ</a>
                                </div>
                            </div>
                            @endforeach
                     
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body">
                                Not user
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
@endsection
