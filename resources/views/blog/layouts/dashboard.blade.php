@extends('Blog.Layouts.Master')
@section('content')
    <link rel="stylesheet" href="{{ asset('blog/css/sidebar-dashboard.css') }}">
    <div class="sidebar" style="opacity: 1;">
        <ul class="nav-links" id="accordion">
            <div id="logo">
                <img id="img_logo" src="{{ asset('Blog/image/laravel.png') }}" alt="">
                <span id="text_logo">Blog User</span>
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
                            <a href="{{ route('infor.view_infor') }}"><i class="fa-solid fa-address-card"></i><span
                                    class="link_name">Update Information</span></a>
                            <a href="#"><i class="fa-solid fa-key"></i><span class="link_name">Change
                                    Password</span></a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div>
                    <a href="#" class="link_arrow" data-toggle="collapse" data-target="#collapseArticle"
                        aria-expanded="true" aria-controls="collapseOne">
                        <i class="fa-brands fa-blogger-b"></i><span class="link_name">Articles</span><i
                            class="bx bxs-chevron-down arrow"></i>
                    </a>
                    <div id="collapseArticle" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body2 list_card">
                            <a href="{{ route('blog.all') }}"><i class="fa-solid fa-list"></i><span class="link_name">All
                                    Article</span></a>
                            <a href="{{ route('blog.my') }}"><i class="fa-solid fa-heart"></i><span class="link_name">My
                                    Article</span></a>
                            <a href="{{ route('blog.add') }}"><i class="fa-solid fa-square-plus"></i><span
                                    class="link_name">Add Article</span></a>
                        </div>
                    </div>
                </div>
            </li>
            <li><a href="{{ route('main.personal_page', ['id_user' => auth()->guard('user')->user()->id]) }}"><i
                        class="fa-solid fa-circle-user"></i><span class="link_name">Personal interface</span></a></li>
            <li><a href="{{ route('chat.view_chat', ['id' => auth()->guard('user')->user()->id]) }}">
                <i class="fa-brands fa-facebook-messenger"></i><span class="link_name">Chat</span></a></li>
            <li><a href="#"><i class="fa-solid fa-circle-question"></i><span class="link_name">Help</span></a></li>
            <li><a href="#"><i class="fa-solid fa-circle-info"></i><span class="link_name">Comment</span></a></li>
            <li>
                <div class="profile-details">
                    <div class="name-job">
                        <div class="profile_name">{{ auth()->guard('user')->user()->name }}</div>
                        <div class="job">User</div>
                    </div>
                    <a href="{{ route('logout') }}" id="logout"><i class="bx bx-log-out"></i></a>
                </div>
            </li>
        </ul>
    </div>
    <div class="home-main">
        @yield('view-content')
    </div>
    <script src="{{ asset('blog/js/sidebar-dashboard.js') }}"></script>
@endsection
