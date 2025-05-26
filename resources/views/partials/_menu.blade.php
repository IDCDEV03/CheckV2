 @php
     use App\Enums\Role;
     $role = Auth::user()->role;
 @endphp
 <div class="sidebar__menu-group">
     <ul class="sidebar_nav">

         <li class="menu-title mt-30">
             @if ($role === Role::Agency)
                 <span>สำหรับหน่วยงาน</span>
             @elseif ($role === Role::User)
                 <span>เมนูผู้ใช้</span>
             @endif
         </li>

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

         @if ($role === Role::Agency)
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
             <li>
                 <a href="#" class="">
                     <span class="nav-icon uil uil-megaphone"></span>
                     <span class="menu-text">ประกาศ</span>
                     <span class="badge badge-info menuItem rounded-circle">8</span>
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
