@props(['activePage'])
@php
    $data = App\Models\AuthorityModel::join('table_urls','table_urls.id','=','authority.linkName_id')
                                ->where('user_id', Auth::user()->id)
                                ->get();
    $userinfo = App\Models\User::where('id', Auth::user()->id)->first();

@endphp
<aside
class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl fixed-start bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <div class="row">
            <div class="col-lg-6">
                <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                    aria-hidden="true" id="iconSidenav"></i>
                <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
                    <img src="{{ asset('assets') }}/img/logos/logo-notext.png" class="img-fluid" alt="main_logo">
                    <span class="ms-2 mt-1 font-weight-bold text-white sidebar-text">Vista</span>
                </a>
            </div>
            <div class="col-lg-6 pt-1 pe-4 text-end">
                <i class="fa-solid fa-circle-arrow-left h5 text-success" id="closeBtn" class="close-btn" style="cursor: pointer;z-index:1000;"></i>
                <i class="fa-solid fa-circle-arrow-right h5 text-success" id="openBtn" class="open-btn" style="cursor: pointer;z-index:1000;"></i>
            </div>
        </div>
        
       
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" style="height: 95%" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item"
            @php
                $checker = false;
            @endphp
            @foreach ($data as $item)
                    @if ($item->linkName === 'dashboard')
                       @php
                           $checker = true;
                       @endphp
                    @endif
            @endforeach
            @if (!$checker)
                style="display: none"
            @endif
            >
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-secondary' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="pe-2  material-icons opacity-10 ">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1 sidebar-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'user-profile' ? 'active bg-gradient-secondary' : '' }} "
                    href="{{ route('profile') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class=" pe-2  fas fa-user-circle "></i>
                    </div>
                    <span class="nav-link-text ms-1 sidebar-text">Profile</span>
                </a>
            </li>
           
            <li class="nav-item mt-3"
            @php
                $checker = false;
            @endphp
            @foreach ($data as $item)
        
                    @if ($item->linkName === 'superadmin')
                       @php
                           $checker = true;
                       @endphp
                    @endif
            @endforeach
            @if (!$checker)
                style="display: none"
            @endif
            >
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder sidebar-text">Super Admin</h6>
            </li>
            <li class="nav-item"
            @php
                $checker = false;
            @endphp
            @foreach ($data as $item)
        
                    @if ($item->linkName === 'superadmin')
                       @php
                           $checker = true;
                       @endphp
                    @endif
            @endforeach
            @if (!$checker)
                style="display: none"
            @endif
            >
                <a class="nav-link text-white {{ $activePage == 'usermanagement.index' ? ' active bg-gradient-secondary' : '' }} "
                    href="{{ route('usermanagement.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul  pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1 sidebar-text">User Management</span>
                </a>
            </li>
            <li class="nav-item"
            @php
                $checker = false;
            @endphp
            @foreach ($data as $item)
        
                    @if ($item->linkName === 'superadmin')
                       @php
                           $checker = true;
                       @endphp
                    @endif
            @endforeach
            @if (!$checker)
                style="display: none"
            @endif
            >
                <a class="nav-link text-white {{ $activePage == 'usermanagement.authority' ? ' active bg-gradient-secondary' : '' }} "
                    href="{{ route('superadmin.authority') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="  pe-2  fa-solid fa-person-military-pointing"></i>
                    </div>
                    <span class="nav-link-text ms-1 sidebar-text">Authority</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
@push('js')
<script>
$("#openBtn").hide();
$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#openBtn').click(function() {
        $('#sidenav-main').css('width', '100%');
        $(".sidebar-text").css('opacity','1');
        $('.main-content').css('margin-left', '17.125rem');
        $('#sidenav-main').removeClass('sidebar_close');
        $("#closeBtn").show();
        $("#openBtn").hide();
        
    });
    
    $('#closeBtn').click(function() {
        $('#sidenav-main').css('width', '4.5rem');
        $(".sidebar-text").css('opacity','0');
        $('.main-content').css('margin-left', '4rem');
        $('#sidenav-main').addClass('sidebar_close');
        $("#closeBtn").hide();
        $("#openBtn").show();
    });

    $('#sidenav-main').hover(
        function() {
            if ($(this).hasClass('sidebar_close')) {
                $('#sidenav-main').css('width', '100%');
                $(".sidebar-text").css('opacity','1');
            }
        },
        function() {
            if ($(this).hasClass('sidebar_close')) {
                $('#sidenav-main').css('width', '4.5rem');
                $(".sidebar-text").css('opacity','0');
            }
        }
    );
});
</script>
@endpush
