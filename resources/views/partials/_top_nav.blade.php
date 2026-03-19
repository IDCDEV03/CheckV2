@php
    use App\Enums\Role;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    $user = Auth::user();
    $role = $user->role; // Enum role จริง
    $activeRole = active_role(); // role ที่กำลังใช้งานจริง
    $agencyLogo = null;

    if ($role === Role::Agency) {
        $agencyLogo = $user->logo_agency;
    } elseif ($user->agency_id) {
        $agency = DB::table('users')->where('id', $user->agency_id)->first();
        $agencyLogo = $agency?->logo_agency;
    }
@endphp

<nav class="navbar navbar-light">
    <div class="navbar-left">
        <div class="logo-area">
            
         @if ($agencyLogo)
                <a class="navbar-brand" href="#">
                    <img class="dark" src="{{ asset($agencyLogo) }}" alt="logo" style="height: 40px; object-fit: contain;">
                    <img class="light" src="{{ asset($agencyLogo) }}" alt="logo" style="height: 40px; object-fit: contain;">
                </a>
            @else
                <a class="navbar-brand" href="#">
                    <img class="dark" src="{{ asset('assets/img/logo-1.png') }}" style="height: 40px; object-fit: contain;" alt="img">
                    <img class="light" src="{{ asset('assets/img/logo-1.png') }}" style="height: 40px; object-fit: contain;" alt="img">
                </a>
            @endif
            <a href="#" class="sidebar-toggle">
                <img class="svg" src="{{ asset('assets/img/svg/align-center-alt.svg') }}" alt="img"></a>
        </div>

        <div class="top-menu">
            <div class="hexadash-top-menu position-relative">
                <ul>
                   <li>
                        <a href="#">
                            <span class="nav-icon uil uil-circle"></span>
                            <span class="menu-text">
                                {{ strtoupper($activeRole ?? $role->value) }}
                            </span>
                        </a>
                        </li>
                       
                        <li class="has-subMenu">
                            <a href="#">Dashboard</a>
                            <ul class="subMenu">
                               @if ($activeRole === 'agency')
                                <li><a href="{{ route('agency.index') }}">หน้าหลักหน่วยงาน</a></li>
                            @elseif ($activeRole === 'user')
                                <li><a href="{{ route('local.home') }}">หน้าหลักผู้ใช้งาน</a></li>
                            @endif

                            </ul>
                        </li>                        
                </ul>
            </div>
        </div>
    </div>
    <div class="navbar-right">
        <ul class="navbar-right__menu">   
            
              {{-- badge แสดงโหมดปัจจุบัน --}}
            <li class="nav-notification">
                @if ($activeRole === 'agency')
                    <span class="dm-tag tag-info tag-transparented fs-18">กำลังใช้งาน (Role): หน่วยงาน</span>
                @elseif ($activeRole === 'user')
                   <span class="dm-tag tag-secondary tag-transparented fs-18">กำลังใช้งาน (Role): เจ้าหน้าที่</span>
                @endif
            </li>

              {{-- ปุ่มสลับ role บน top nav --}}
            @if ($role === Role::Agency && $user->can_switch)
                <li class="nav-notification">
                    @if ($activeRole === 'agency')
                        <form action="{{ route('role.switch.user') }}" method="POST" class="mb-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-default btn-squared color-primary btn-outline-primary">
                                 <span class="nav-icon uil uil-exchange"></span>
                                เข้าสู่โหมดเจ้าหน้าที่
                            </button>
                        </form>
                    @elseif ($activeRole === 'user')
                        <form action="{{ route('role.switch.agency') }}" method="POST" class="mb-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-default btn-squared color-primary btn-outline-dark">
                                 <span class="nav-icon uil uil-exchange"></span>
                                กลับสู่โหมดหน่วยงาน
                            </button>
                        </form>
                    @endif
                </li>
            @endif

           
             <li class="nav-author">
                <div class="dropdown-custom">
                    <a href="javascript:;" class="nav-item-toggle">
                        <img src="{{ asset('settings.png') }}" alt="" class="rounded-circle">
                    

                    
                        @if (Auth::check())
                            <label class="nav-item__title">
                                {{ $user->name }} {{ $user->lastname }}
                                <i class="las la-angle-down nav-item__arrow"></i>
                            </label>
                        @endif
                    </a>
                    <div class="dropdown-wrapper">
                        <div class="nav-author__info">                          
                            <div>
                                 <span class="fs-14 fw-bold text-capitalize">
                                    {{ $user->name }} {{ $user->lastname }}
                                </span>

                                @if ($activeRole === 'user')
                                    <br><span>เจ้าหน้าที่</span>
                                @elseif ($activeRole === 'agency')
                                    <br><span>หน่วยงาน</span>
                                @elseif ($role === Role::Manager)
                                    <br><span>Manager</span>
                                @endif
                                
                            </div>
                        </div>
                        <div class="nav-author__options">

                           @if ($activeRole === 'user')
                                <ul>
                                <li>
                                    <a href="{{route('user.profile')}}">
                                        <img src="{{ asset('assets/img/svg/user.svg') }}" alt="user"
                                            class="svg"> บัญชีผู้ใช้</a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('assets/img/svg/settings.svg') }}" alt="settings"
                                            class="svg"> ตั้งค่า</a>
                                </li>
                               
                                
                            </ul>
                              @elseif ($activeRole === 'agency')
                                <ul>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('assets/img/svg/user.svg') }}" alt="user"
                                            class="svg"> Profile</a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('assets/img/svg/settings.svg') }}" alt="settings"
                                            class="svg"> Settings</a>
                                </li>
                                </ul>
                            @endif
                            
                            <a href="#" class="nav-author__signout"
                                onclick="event.preventDefault(); document.getElementById('logout').submit();">
                               <img src="{{ asset('assets/img/svg/log-out.svg') }}" alt="log-out" class="svg"> ออกจากระบบ 
                            </a>

                            <form id="logout" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="navbar-right__mobileAction d-md-none">
            <a href="#" class="btn-search">
                <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg feather-search">
                <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg feather-x">
            </a>
            <a href="#" class="btn-author-action">
                <img src="{{ asset('assets/img/svg/more-vertical.svg') }}" alt="more-vertical" class="svg">
           </a>
        </div>
    </div>
</nav>
