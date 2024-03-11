@extends('admin.Layouts.Master')
@section('content')
    <link rel="stylesheet" href="{{ asset('admin/css/sidebar-dashboard.css') }}">
    <div class="sidebar" style="opacity: 1;">
        <ul class="nav-links" id="accordion">
            <div id="logo">
                <img id="img_logo" src="{{ asset('admin/img/logo.png') }}" alt="">
                <span id="text_logo">Blog Admin</span>
                <span id="show_sidebar"><i class="bx bx-menu"></i></span>
            </div>
            <li><a href="{{ route('main.view_main') }}"><i class="fa-solid fa-house"></i><span
                        class="link_name">Home</span></a></li> {{-- link đơn --}}
            <li>
                <div>
                    <a style="font-weight: 500 !important;" href="#" class="link_arrow" data-toggle="collapse"
                        data-target="#collapseUser" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fa-solid fa-user-gear"></i>
                        <span class="link_name">Information Settings</span>
                        <i class="bx bxs-chevron-down arrow"></i>
                    </a>
                    <div id="collapseUser" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body2 list_card">
                            <a href="{{ route('admin.view_infor') }}"><i class="fa-solid fa-address-card"></i><span
                                    class="link_name">Update Information</span></a>
                            <a href="#"><i class="fa-solid fa-key"></i><span class="link_name">Change
                                    Password</span></a>
                        </div>
                    </div>
                </div>
            </li>
            <li><a href="{{ route('admin.statistical')}}">
                <i class="fa-solid fa-chart-pie"></i><span class="link_name">Statistical</span></a></li>
            <li><a href="{{ route('admin.article') }}">
                <i class="fa-regular fa-newspaper"></i><span class="link_name">Articles</span>
            </a></li>
            <li><a href="{{ route('admin.comment') }}">
                <i class="fa-solid fa-comments"></i><span class="link_name">Comments</span>
            </a></li>
            <li><a href="{{ route('admin.user') }}">
                <i class="fa-solid fa-user-gear"></i><span class="link_name">User Management</span>
            </a></li>

            @if(auth()->guard('admin')->user()->role != 0)
            <li><a href="{{ route('admin.all_admin') }}">
                <i class="fa-solid fa-user-shield"></i><span class="link_name">Admin Management</span>
            </a></li>
            @endif
            <li>
                <div class="profile-details">
                    <div class="name-job">
                        <div class="profile_name">{{ auth()->guard('admin')->user()->name }}</div>
                        @if(auth()->guard('admin')->user()->role == 1)
                        <div class="job">Super Admin</div>
                        @elseif(auth()->guard('admin')->user()->role == 2)
                        <div class="job">Manager</div>
                        @else 
                        <div class="job">Admin</div>
                        @endif
                    </div>
                    <a href="{{ route('admin.logout') }}" id="logout"><i class="bx bx-log-out"></i></a>
                </div>
            </li>
        </ul>
    </div>
    <div class="home-main">
        @yield('view-content')
    </div>
    <script src="{{ asset('blog/js/sidebar-dashboard.js') }}"></script>
@endsection
