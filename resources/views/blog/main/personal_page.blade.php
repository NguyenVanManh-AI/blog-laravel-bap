@extends('Blog.Layouts.Master')
@section('content')
    <link rel="stylesheet" href="{{ asset('blog/css/main/personal_page.css') }}">
    <link rel="stylesheet" href="{{ asset('blog/css/personal-page.css') }}">
    <div id="big_infor">
        <div id="header_infor" class="sticky" style="background-color: white;">
            <div id="top_infor">
                <div id="thumbnail">
                    @if (\Illuminate\Support\Str::startsWith($personal->avatar, 'http'))
                        <img id="upload_img" src="{{ $personal->avatar }}">
                    @else
                        <img id="upload_img" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $personal->avatar }}">
                    @endif
                </div>
            </div>
            <div id="bottom_infor">
                <div id="avatar_infor">
                    @if (\Illuminate\Support\Str::startsWith($personal->avatar, 'http'))
                        <img id="upload_img" src="{{ $personal->avatar }}">
                    @else
                        <img id="upload_img" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $personal->avatar }}">
                    @endif
                </div>
                <div id="full_infor_user">
                    <div>
                        <div style="font-weight: bold;font-size: 26px;">
                            {{ $personal->name }} 
                            @if($personal->status == 0)
                            <i class="fa-solid fa-lock" style="color:#721c24"></i>
                            @else 
                            <i class="fa-solid fa-circle-check" style="color: #0076e5;"></i>
                            @endif
                        </div>
                        @if($personal->status == 0)
                        <div style="font-size: 20px;color:#721c24;">
                            <i class="fa-solid fa-lock"></i>
                            {{ $articles->total() }} Articles <i class="fa-solid fa-blog"></i>
                        </div>
                        <div class="mt-2">
                            <a id="text_me_chat" href="#" style="background-color: #721c24">
                                <span><i class="fa-brands fa-facebook-messenger"></i></span>
                                Text Me
                            </a>
                        </div>
                        @else 
                        <div style="font-size: 20px;color: #0076e5;">
                            {{ $articles->total() }} Articles <i class="fa-solid fa-blog"></i>
                        </div>
                        <div class="mt-2">
                            <a id="text_me_chat" href="/chat/user/{{$personal->id}}">
                                <span><i class="fa-brands fa-facebook-messenger"></i></span>
                                Text Me
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div id="body_infor" class="d-flex">
            <div class="col-2" style="background-color: #F2F4F6;"></div>
            <div class="col-3 pt-2" id="left_body" style="height: 100vh;background-color: #F2F4F6;">
                <div id="infor_details">
                    <h1
                        style="font-weight: bold;font-size: 18px;margin-bottom: 20px;word-spacing: 2px;font;text-transform: uppercase;color: #0076e5;">
                        <i class="fa-solid fa-address-card"></i> Introduce yourself</h1>
                    <li><span class="icon"><i class="fa-solid fa-signature"></i></span> <span
                            class="name">{{ $personal->name }}</span></li>
                    <li><span class="icon"><i class="fa-solid fa-venus-mars"></i></span>
                        @if ($personal->gender == 1)
                            <span class="name">Men</span>
                        @else
                            <span class="name">Women</span>
                        @endif
                    </li>
                    <li><span class="icon"><i class="fa-solid fa-blog"></i></span> <span
                            class="name">{{ $articles->total() }} Articles</span></li>
                    <h1
                        style="font-weight: bold;font-size: 18px;margin-bottom: 20px;margin-top: 30px;word-spacing: 2px;font;text-transform: uppercase;color: #0076e5;">
                        <i class="fa-solid fa-phone"></i> Contact Info</h1>
                    <li style="color: #0076e5;"><a href="mailto:{{ $personal->email }}"><span class="icon"><i
                                    class="fa-solid fa-envelope"></i></span> <span
                                class="name">{{ $personal->name }}</span></a></li>
                </div>
            </div>
            <div class="col-5 pr-0 pl-0 mt-2">
                @include('blog.main.personal_middle')

            </div>
            <div class="logo_blog"><img src="{{ asset('Blog/image/logo.png') }}" /></div>
            <div id="toTop" v-if="showButton"><i class="fa-solid fa-chevron-up"></i></div>
            <script>
                $('.logo_blog').on('click', function() {
                    window.location.href = "/main/view";
                });
                var btn = $('#button');
                $('#toTop').on('click', function(e) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: 0
                    }, '300');
                    $('#dashboard_user').animate({
                        scrollTop: 0
                    }, '300');
                    $('.main_content').animate({
                        scrollTop: 0
                    }, '300');
                });
            </script>
        </div>
    </div>
@endsection
