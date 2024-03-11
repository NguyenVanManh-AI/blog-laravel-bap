@extends('admin.layouts.view_content')
@section('content-blog')
    <link rel="stylesheet" href="{{ asset('admin/css/detail_article.css') }}">
    <br>
    <div class="col-12 mx-auto">
        @csrf
        <div class="form-group">
            <p id="p_title"><label style="margin-right: 10px" for="title"><i class="fa-solid fa-blog"></i></label>
                {{ $article->title }}</p>
        </div>
        <div class="form-group">
            <div id="div_content">
                {!! $article->content !!}
            </div>
        </div>
    </div>
@endsection
