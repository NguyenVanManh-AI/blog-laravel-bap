@extends('admin.layouts.view_content')
@section('content-blog')
    {{-- <link rel="stylesheet" href="{{ asset('admin/css/all.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('admin/css/admin.css') }}">
    <div class="col-12 mx-auto" id="index_article">
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-1 col-form-label">Search</label>
            <div class="col-sm-7">
                <input value="{{$input->search}}" name="title" type="text" class="form-control" id="search"
                    aria-describedby="titleHelp" placeholder="Search">
            </div>
            <div class="col-2 ml-0 mr-0 pl-0 pr-0">
                <select id="search-role" name="search-role" class="form-control">
                    @foreach ([null => 'All', 0 => 'Admin', 1 => 'Super Admin', 2 => 'Manager'] as $value => $label)
                        <option value="{{ $value }}" @if($input->role === $value) selected @endif>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-2 mr-0 pl-4 pr-4" style="display: flex;justify-content: end;">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa-solid fa-user-plus"></i></button>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Account</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="body-admin">
                @foreach ($admins as $index => $admin)
                <tr>
                    <th scope="row">{{ $admins->perPage() * ($admins->currentPage() - 1) + $index + 1 }}</th>
                    <td>
                        <div class="cell1">
                            <div>
                                <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $admin->avatar }}">
                            </div>
                            <div>
                                <p class="p-0 m-0">{{$admin->name}}</p>
                                <p class="p-0 m-0" style="color:gray">{{$admin->created_at}}</p>
                            </div>
                        </div>
                    </td>
                    <td>{{$admin->email}}</td>
                    <td>
                        @if($admin->id != auth()->guard('admin')->user()->id)
                            @if($admin->role == 0 || auth()->guard('admin')->user()->role == 2)
                                <select id="change_admin_{{$admin->id}}" data-id_admin="{{$admin->id}}" class="role-admin form-control form-control-sm">
                                    <option value="1" {{ $admin->role == 1 ? 'selected' : '' }}>Super Admin</option>
                                    <option value="0" {{ $admin->role == 0 ? 'selected' : '' }}>Admin</option>
                                </select>
                            @else
                                @if($admin->role == 1)
                                    Super Admin
                                @else 
                                    Manager
                                @endif
                            @endif
                        @else
                            @if($admin->role == 1)
                                Super Admin
                            @else 
                                Manager
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($admin->id != auth()->guard('admin')->user()->id)
                            @if($admin->role == 0 || auth()->guard('admin')->user()->role == 2)
                            <form id="del_admin_{{$admin->id}}" method="POST" action="{{ route('admin.delete_admin', $admin->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this admin ?');">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i>
                                    Delete</button>
                            </form>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Modal Add Admin -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('admin.add_admin')}}">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-user-plus"></i> Add Admin</h5>
                    <button type="button" style="outline: none" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><i class="fa-solid fa-signature"></i> Name Admin</label>
                                <input required name="name" minlength="6" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Full Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><i class="fa-solid fa-envelope"></i> Email address </label>
                                <input required name="email" minlength="6" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
                            </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
        <br>
        <br>
        <div class="row m-0 p-0" id="page_bottom">
            <div id="pagination_container">
                {{ $admins->links() }}
            </div>
            <div id="div_per_page">
                <select id="per_page" class="ml-2 form-control form-control">
                    <option value="5" @if($input->per_page == 5) selected @endif>5</option>
                    <option value="10" @if($input->per_page == 10) selected @endif>10</option>
                    <option value="15" @if($input->per_page == 15) selected @endif>15</option>
                    <option value="20" @if($input->per_page == 20) selected @endif>20</option>
                    <option value="9999" @if($input->per_page == 9999) selected @endif>All</option>
                </select>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/js/admin.js') }}"></script>
@endsection
