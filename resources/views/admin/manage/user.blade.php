@extends('admin.layouts.view_content')
@section('content-blog')
    <link rel="stylesheet" href="{{ asset('admin/css/user.css') }}">
    <div class="col-12 mx-auto" id="index_article">
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-1 col-form-label">Search</label>
            <div class="col-sm-7">
                <input value="{{$input->search}}" name="title" type="text" class="form-control" id="search"
                    aria-describedby="titleHelp" placeholder="Search">
            </div>
            <div class="col-2 ml-0 mr-0 pl-0 pr-0">
                <select id="search-block" name="search-block" class="form-control">
                    @foreach ([null => 'Both', 0 => 'Is Block', 1 => 'Is Accept'] as $value => $label)
                        <option value="{{ $value }}" @if($input->block == $value) selected @endif>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Account</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody id="body-user">
                @foreach ($users as $index => $user)
                <tr>
                    <th scope="row">{{ $users->perPage() * ($users->currentPage() - 1) + $index + 1 }}</th>
                    <td>
                        <div class="cell1">
                            <div>
                                @if (\Illuminate\Support\Str::startsWith($user->avatar, 'http'))
                                    <img src="{{ $user->avatar }}">
                                @else
                                    <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user->avatar }}">
                                @endif
                            </div>
                            <div>
                                <p class="m-0 p-0 name-user"><a href="{{ route('main.personal_page', ['id_user' => $user->id]) }}">{{$user->name}}</a></p>
                                <p class="m-0 p-0" style="color:gray">{{$user->username}}</p>
                            </div>
                        </div>
                    </td>
                    <td>{{$user->email}}</td>
                    <td style="padding-left: 0px;">
                        <div class="big-toggle" >
                            <div class="button2 r button-6">
                                @if($user->status == 0)
                                <input data-id_user="{{$user->id}}" checked type="checkbox" class="checkbox" />
                                {{-- <input data-id_user="{{$user->id}}" data-status="{{$user->status}}" checked type="checkbox" class="checkbox" /> --}}
                                @else 
                                <input data-id_user="{{$user->id}}" type="checkbox" class="checkbox" />
                                {{-- <input data-id_user="{{$user->id}}" data-status="{{$user->status}}" type="checkbox" class="checkbox" /> --}}
                                @endif
                                <div class="knobs"></div>
                                <div class="layer"></div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <br>
        <div class="row m-0 p-0" id="page_bottom">
            <div id="pagination_container">
                {{ $users->links() }}
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
    <script src="{{ asset('admin/js/user.js') }}"></script>
@endsection
    