@extends('Blog.layouts.view_content')
@section('content-blog')
    <link rel="stylesheet" href="{{ asset('blog/css/edit_article.css') }}">
    <div class="col-12 mx-auto">
        <form method="POST" action="{{ route('blog.update') }}">
            @csrf
            <input hidden value="{{ old('id', $article->id) }}" name="id" type="text" class="form-control"
                id="id_article" aria-describedby="titleHelp" placeholder="Title">
            <div class="form-group">
                <label for="title" class="title_blog"><i class="fa-solid fa-blog"></i> Title</label>
                <input value="{{ old('title', $article->title) }}" name="title" type="text" class="form-control"
                    id="title" aria-describedby="titleHelp" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="content" class="title_blog"><i class="fa-brands fa-microblog"></i> Content</label>
                <textarea name="content" class="form-control" id="content" rows="5" placeholder="Content">{{ old('content', $article->content) }}</textarea>
            </div>
            <button id="submit-btn-edit" type="submit" class="btn btn-outline-primary"><i
                    class="fa-solid fa-floppy-disk"></i></button>
        </form>
    </div>
    <script>
        var editor1 = new RichTextEditor("#content");
    </script>
@endsection
