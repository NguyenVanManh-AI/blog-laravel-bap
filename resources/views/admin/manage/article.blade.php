@extends('admin.layouts.view_content')
@section('content-blog')
    <link rel="stylesheet" href="{{ asset('admin/css/all.css') }}">
    <div class="col-12 mx-auto" id="index_article">
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-1 col-form-label">Search</label>
            <div class="col-sm-7">
                <input value="" name="title" type="text" class="form-control" id="search"
                    aria-describedby="titleHelp" placeholder="Search">
            </div>
            <div class="col-2 ml-0 mr-0 pl-0 pr-0">
                <select id="search-role" name="search-role" class="form-control">
                    @foreach ($nameUsers as $index => $nameUser)
                        <option value="{{ $nameUser->name }}" >{{ $nameUser->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><i class="fa-solid fa-blog mr-2"></i> Title</th>
                    <th scope="col"><i class="fa-solid fa-at mr-2"></i> Author</th>
                    <th scope="col" colspan="2"><i class="fa-solid fa-bars-staggered mr-2"></i> Features</th>
                </tr>
            </thead>
            <tbody id="body-article">
                @foreach ($articles as $index => $article)
                    <tr>
                        <th>{{ $articles->perPage() * ($articles->currentPage() - 1) + $index + 1 }}</th>
                        <td>{{ \Illuminate\Support\Str::limit($article->title, 69, '...') }}</td>
                        <td>{{ $article->name }}</td>
                        <td>
                            <a href="{{ route('admin.show', ['id' => $article->id]) }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-eye"></i> View
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.delete_article', $article->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this article ?');">
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
    <script src="{{ asset('admin/js/search-all.js') }}"></script>
@endsection
@push('styles-index')
    <style>
    </style>
@endpush
@push('scripts-index')
    <script>
        console.log('Hello INDEX');
    </script>
@endpush
