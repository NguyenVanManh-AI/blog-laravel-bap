@extends('admin.layouts.view_content')
@section('content-blog')
    <link rel="stylesheet" href="{{ asset('admin/css/all.css') }}">
    <div class="col-12 mx-auto" id="index_article">
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
                    <th scope="col"><i class="fa-solid fa-at mr-2"></i> User</th>
                    <th scope="col"><i class="fa-solid fa-bars-staggered mr-2"></i> Features</th>
                </tr>
            </thead>
            <tbody id="body-article">
                @foreach ($comments as $index => $comment)
                    <tr>
                        <th>{{ $comments->perPage() * ($comments->currentPage() - 1) + $index + 1 }}</th>
                        <td>{{ \Illuminate\Support\Str::limit($comment->content, 69, '...') }}</td>
                        <td>{{ $comment->name }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.delete_comment', $comment->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this comment ?');">
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
            {{ $comments->links() }}
        </div>
    </div>
    <script src="{{ asset('admin/js/search-all-cmt.js') }}"></script>
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
