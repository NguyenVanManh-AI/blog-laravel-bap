@extends('admin.layouts.view_content')
@section('content-blog')
    <link rel="stylesheet" href="{{ asset('admin/css/view_infor.css') }}">
    <div class="container_big" style="padding: 0px 30px">
        <div class="pt-3" id="big_update">
            {{-- @if (\Illuminate\Support\Str::startsWith($admin->avatar, 'http'))
                <img src="{{ $admin->avatar }}">
            @else
                <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $admin->avatar }}">
            @endif --}}
            <form method="POST" action="{{ route('admin.update_infor') }}" enctype="multipart/form-data">
                @csrf
                <br>
                <p id="title_update_infor"><i class="fa-solid fa-circle-user"></i> Update Information</p>
                <div class="form-group row ml-2 mr-2">
                    <div class="col-8">
                        <div class="row mb-3">
                            <label for="inputPassword" class="col-sm-3 col-form-label"><i
                                    class="fa-solid fa-user-check mr-1"></i> Full Name</label>
                            <div class="col-sm-9">
                                <input value="{{ old('name', $admin->name) }}" name="name" type="text"
                                    class="form-control" id="floatingInputName" placeholder="Full Name" required autofocus>
                            </div>
                        </div>
                        @if ($errors->has('name'))
                        <div class="row mb-3">
                            <label for="inputPassword" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <span class="text-danger ml-3">{{ $errors->first('name') }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="row mb-3">
                            <label for="staticEmail" class="col-sm-3 col-form-label"><i
                                    class="fa-solid fa-envelope-circle-check mr-1"></i> Email</label>
                            <div class="col-sm-9">
                                <input hidden value="{{ old('email', $admin->email) }}" name="email" type="email"
                                    class="form-control" id="floatingInputEmail" placeholder="email@example.com" required>
                                <input disabled value="{{ old('email', $admin->email) }}" name="email" type="email"
                                    class="form-control" id="floatingInputEmail" placeholder="email@example.com" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-4" id="upload_file_img">
                        <div id="dropbox">
                            <input type="file" name="avatar" id="image" accept="image/*">
                            <label for=""><i class="fa-solid fa-wand-magic-sparkles"></i> Avatar User</label>
                            <p>
                                @if (\Illuminate\Support\Str::startsWith($admin->avatar, 'http'))
                                    <img id="upload_img" src="{{ $admin->avatar }}">
                                @else
                                    <img id="upload_img" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $admin->avatar }}">
                                @endif
                            </p>
                        </div>
                        <div id="image-container">
                            <img id="image-preview" src="#" alt="Preview">
                            <img id="cancel-btn" src="{{ asset('Blog/image/icon/error.png') }}">
                        </div>
                    </div>
                    <script>
                        function readURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    $('#image-container').css('display', 'inline-block');
                                    $('#image-preview').attr('src', e.target.result);
                                    $('#image-preview').show();
                                    $('#dropbox').hide();
                                    $('#cancel-btn').show();
                                }
                                reader.readAsDataURL(input.files[0]);
                            }
                        }

                        $("#image").change(function() {
                            readURL(this);
                        });

                        $("#cancel-btn").click(function() {
                            $('#image-container').hide();
                            $('#image-preview').hide();
                            $('#dropbox').val('').show();
                            $('#cancel-btn').hide();
                            $('#image').val('');
                        });
                    </script>
                </div>
                <div class="d-grid mb-2 mt-2">
                    <div class="col-2 mx-auto">
                        <button class="col-12 mx-auto btn btn-outline-success text-uppercase" type="submit"><i
                                class="fa-solid fa-floppy-disk mr-2"></i> SAVE</button>
                    </div>
                </div>
            </form>
            <br>
            <hr>
            <form method="POST" action="{{ route('admin.change_password') }}" enctype="multipart/form-data">
                @csrf
                <p id="title_update_infor"><i class="fa-solid fa-bolt"></i> Change Password</p>
                <div class="col-7 mx-auto">
                    @if (Auth::user()->password)
                        <div class="row mb-2">
                            <label for="inputPassword" class="col-sm-5 col-form-label"><i
                                    class="fa-solid fa-key mr-1"></i></i>Old Password</label>
                            <div class="col-sm-7">
                                <input minlength="6" value="{{ old('name') }}" name="old_password" type="password"
                                    class="form-control" id="floatingInputName" placeholder="Old Password" required
                                    autofocus>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="inputPassword" class="col-sm-5 col-form-label"><i
                                    class="fa-solid fa-key mr-1"></i></i>Confirm Old Password</label>
                            <div class="col-sm-7">
                                <input minlength="6" value="{{ old('name') }}" name="confirm_old_password"
                                    type="password" class="form-control" id="floatingInputName"
                                    placeholder="Confirm Old Password" required autofocus>
                            </div>
                        </div>
                    @endif
                    <div class="row mb-2">
                        <label for="inputPassword" class="col-sm-5 col-form-label"><i
                                class="fa-solid fa-key mr-1"></i></i>New Password</label>
                        <div class="col-sm-7">
                            <input minlength="6" value="{{ old('name') }}" name="new_password" type="password"
                                class="form-control" id="floatingInputName" placeholder="New Password" required
                                autofocus>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-2 mx-auto">
                        <button class="col-12 mx-auto btn btn-outline-success text-uppercase" type="submit"><i
                                class="fa-solid fa-floppy-disk mr-2"></i> SAVE</button>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>
@endsection
