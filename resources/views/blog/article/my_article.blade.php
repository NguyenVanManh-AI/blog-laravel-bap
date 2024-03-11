@extends('Blog.layouts.view_content')
@section('content-blog')
    <div class="col-12 mx-auto" id="my_article">
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-1 col-form-label">Search</label>
            <div class="col-sm-11">
                <input value="" name="title" type="text" class="form-control" id="search"
                    aria-describedby="titleHelp" placeholder="Search">
            </div>
        </div>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><i class="fa-solid fa-blog mr-2"></i> Title</th>
                    <th scope="col" colspan="3"><i class="fa-solid fa-bars-staggered mr-2"></i> Features</th>
                </tr>
            </thead>
            <tbody id="body-article">
                @if (count($articles) == 0)
                    <div class="alert alert-success text-center" role="alert">
                        <i class="fa-solid fa-star"></i> You have no posts yet. Let's go create an article !
                    </div>
                @endif
                @foreach ($articles as $index => $article)
                    <tr>
                        <th>{{ $articles->perPage() * ($articles->currentPage() - 1) + $index + 1 }}</th>
                        <td>{{ \Illuminate\Support\Str::limit($article->title, 69, '...') }}</td>
                        <td>
                            <a href="{{ route('blog.show', ['id' => $article->id]) }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-eye"></i> View
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('blog.show_edit', ['id' => $article->id]) }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('blog.delete', $article->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this article?');">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i>
                                    Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div id="pagination_container">
            {{ $articles->links() }}
        </div>
    </div>
    <script src="{{ asset('blog/js/search-my.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('blog/css/my.css') }}">
@endsection
