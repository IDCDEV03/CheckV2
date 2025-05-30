 @php
     use App\Enums\Role;
     $role = Auth::user()->role;
 @endphp
 <div class="sidebar__menu-group">
     <ul class="sidebar_nav">

         <li class="menu-title mt-30">
             @if ($role === Role::Agency)
                 <span>ระบบปฏิบัติการพนักงานขับรถราชการ</span>
                   <span>เมนูสำหรับหน่วยงาน</span>
             @elseif ($role === Role::User)
                 <span>ระบบปฏิบัติการพนักงานขับรถราชการ</span>
                 <span>เมนูสำหรับผู้ใช้งาน</span>
             @endif
         </li>

   
         @if ($role === Role::Agency)
               <li class="has-child {{ Request::is(app()->getLocale() . '/dashboards/*') ? 'open' : '' }}">
             <a href="#" class="{{ Request::is(app()->getLocale() . '/dashboards/*') ? 'active' : '' }}">
                 <span class="nav-icon uil uil-create-dashboard"></span>
                 <span class="menu-text">หน้าหลัก</span>
                 <span class="toggle-icon"></span>
             </a>
             <ul>
                 <li class="{{ Request::is(app()->getLocale() . '/dashboard') ? 'active' : '' }}"><a href="#">#</a>
                 </li>

             </ul>
         </li>

             <li>
                 <a href="{{ route('agency.main') }}" class="">
                     <span class="nav-icon uil uil-megaphone"></span>
                     <span class="menu-text">ประกาศ</span>
                     <span class="badge badge-success menuItem rounded-circle">3</span>
                 </a>
             </li>

                 <li class="has-child">
             <a href="#" class="">
                 <span class="nav-icon far fa-list-alt"></span>
                 <span class="menu-text">แบบฟอร์ม</span>
                 <span class="toggle-icon"></span>
             </a>
             <ul>
                 <li>
                    <a href="{{route('agency.form_list')}}">รายการฟอร์ม</a>
                 </li>
                 <li>
                    <a href="{{route('agency.create_form')}}">สร้างฟอร์ม</a>
                 </li>

             </ul>
         </li>
         @elseif ($role === Role::User)
               <li class="has-child">
             <a href="#" class="">
                 <span class="nav-icon uil uil-create-dashboard"></span>
                 <span class="menu-text">หน้าหลัก</span>
                 <span class="toggle-icon"></span>
             </a>
             <ul>
                 <li class="">
                    <a href="{{route('local.home')}}">Main</a>
                 </li>

             </ul>
         </li>

             <li>
                 <a href="#" class="">
                     <span class="nav-icon uil uil-megaphone"></span>
                     <span class="menu-text">ประกาศ</span>
                     <span class="badge badge-info menuItem rounded-circle">8</span>
                 </a>
             </li>
               <li>
                 <a href="{{route('user.chk_list')}}" class="">
                     <span class="nav-icon uil uil-document-layout-left"></span>
                     <span class="menu-text">รายการตรวจรถ</span>                   
                 </a>
             </li>
                <li>
                 <a href="{{route('user.profile')}}" class="">
                     <span class="nav-icon uil uil-user"></span>
                     <span class="menu-text">บัญชีผู้ใช้</span>                   
                 </a>
             </li>
        @elseif ($role === Role::Manager)
             <li>
                 <a href="#" class="">
                     <span class="nav-icon uil uil-megaphone"></span>
                     <span class="menu-text">ประกาศ</span>
                     <span class="badge badge-info menuItem rounded-circle">2</span>
                 </a>
             </li>
         @endif



     </ul>
 </div>
