@section('title', 'ระบบปฏิบัติการพนักงานขับรถราชการ')
@section('description', 'ID Drives')
@extends('layout.app')
@section('content')

    <div class="container-fluid">
          <div class="row justify-content-center">
               <div class="col-12">
                  <div class="min-vh-100 content-center">
                     <div class="maintenance-page text-center">
                        <img src="{{asset('chat.png')}}" alt="maintenance" width="256px" />
                        <br>
                        <span class="fs-24 fw-bold maintenance-page__title">สนใจใช้งานระบบติดต่อได้ที่</span>
                        <br>
                        <span class="fs-20 fw-500">
                          <a href="mailto:idc@iddrives.co.th">idc@iddrives.co.th</a>
                           หรือ โทร.065-083-7000</span>
                     </div>
                  </div>
               </div>
            </div>
    </div>
@endsection

