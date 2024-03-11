@extends('Blog.Layouts.Master')
@section('content')
    <link rel="stylesheet" href="{{ asset('blog/css/main/main.css') }}">
    <div id="big_main">
        <div id="left_main">
            @include('blog.main.left')
        </div>
        <div id="middle_main">
            @include('blog.main.middle')
        </div>
        <div id="right_main">
            @include('blog.main.right')
        </div>
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
@endsection
