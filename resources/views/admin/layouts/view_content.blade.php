@extends('admin.layouts.dashboard')
@section('view-content')
<link rel="stylesheet" href="{{ asset('admin/css/view-content.css') }}">
<div id="view-content" >
    <div id="view-content-min">
        <div id="header-main" >
            <a class="style_a" data-replace="{{$title['title_main']}}" id="title_main"><span>{{$title['title_main']}}</span></a> 
            <i class="fa-solid fa-angles-right"></i>
            <a class="style_a" data-replace="{{$title['title_sub']}}" id="title_sub"><span>{{$title['title_sub']}}</span></a> 
            @if(request()->routeIs('blog.show') || request()->routeIs('blog.show_edit'))
            <i class="fa-solid fa-angles-right"></i>
            <a class="style_a" data-replace="{{\Illuminate\Support\Str::limit($article->title, 59, '...')}}" id="title_article"><span>{{\Illuminate\Support\Str::limit($article->title, 59, '...')}}</span></a> 
            @endif
            @if(request()->routeIs('admin.view_infor')) 
            <i class="fa-solid fa-angles-right"></i>
            <a class="style_a" data-replace="{{\Illuminate\Support\Str::limit(auth()->guard('admin')->user()->name, 59, '...')}}" ><span>{{\Illuminate\Support\Str::limit(auth()->guard('admin')->user()->name, 59, '...')}}</span></a> 
            @endif
        </div>
        <div id="content-main">
            @yield('content-blog')
        </div>
    </div>
    <br>
</div>
@endsection

