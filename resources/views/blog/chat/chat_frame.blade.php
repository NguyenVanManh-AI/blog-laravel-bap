@extends('Blog.layouts.view_content')
@section('content-blog')
<link rel="stylesheet" href="{{ asset('blog/css/chat_frame.css') }}">
    <div class="col-12 mx-auto" id="index_chat">
        <div class="row">
            <div id="left_chat" class="col-4 m-0 p-0">
                <div class="main_right col-12 d-flex pb-3 pt-2" >
                    <div class="form_search">
                        <div class="input-group">
                            <input type="text" class="shadow-none form-control" id="text_search" placeholder="Search name user">
                            <div class="input-group-prepend">
                                <div class="input-group-text" ><i class="fa-solid fa-magnifying-glass"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row hidden" id="list_search" >
                    <div class="col-12 p-1" id="inner_search">
                    </div>
                </div>
                <div id="big_chatting">
                    @foreach($listUsers as $index => $userChat)
                        <div data-id_to_user="{{$userChat->id}}" class="chatting" id="chatting_{{$userChat->id}}">
                            <div>
                                @if (\Illuminate\Support\Str::startsWith($userChat->avatar, 'http'))
                                    <img src="{{ $userChat->avatar }}">
                                @else
                                    <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $userChat->avatar }}">
                                @endif
                                <span class="user_online"><i class="fa-solid fa-circle"></i></span>
                            </div>
                            <div class="chatting_infor" id="div_content_{{$userChat->id}}">
                                <p class="m-0 p-0">{{$userChat->name}}</p>
                                @if($userChat->content == '&&like&&')
                                    <p class="m-0 p-0" id="p_content_{{$userChat->id}}">
                                        @if($userChat->id_from_content == auth()->guard('user')->user()->id) 
                                            You : 
                                        @endif
                                        <i class="like_message fa-solid fa-thumbs-up"></i>
                                    </p>
                                @else 
                                    <p class="m-0 p-0" id="p_content_{{$userChat->id}}">
                                        @if($userChat->id_from_content == auth()->guard('user')->user()->id) 
                                            You : 
                                        @endif
                                        {{$userChat->content}}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <hr class="col-8 mx-auto" id="hr_chatting_{{$userChat->id}}">
                    @endforeach
                </div>
            </div>
            <div id="right_chat" class="col-8 m-0 p-0">
                <div id="header_chat" data-id_user_to="{{$user_to->id}}">
                    <div >
                        @if (\Illuminate\Support\Str::startsWith($user_to->avatar, 'http'))
                            <img src="{{ $user_to->avatar }}">
                        @else
                            <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user_to->avatar }}">
                        @endif
                    </div>
                    <div id="infor_user_to">
                        <p><a href="{{ route('main.personal_page', ['id_user' => $user_to->id]) }}">{{$user_to->name}}</a></p>
                        <p><i class="fa-regular fa-clock"></i> {{$user_to->created_at}}</p>
                    </div>
                </div>
                <div id="chat_box">
                    <div id="inner_box">
                        @foreach ($listMessages as $index => $message)
                            @if ($message->id_from != auth()->guard('user')->user()->id)
                                <div id="big_message_from_{{$message->id_message}}" class="message_to setting_chat" >
                                    @if ($index == count($listMessages) - 1 || $message->id_from != $listMessages[$index + 1]->id_from)
                                        @if (\Illuminate\Support\Str::startsWith($message->avatar, 'http'))
                                            <img src="{{ $message->avatar }}">
                                        @else
                                            <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $message->avatar }}">
                                        @endif
                                    @else 
                                        <span class="img_hide"></span>
                                    @endif
                                    @if($message->content == '&&like&&')
                                    <span class="like_left"><i class="fa-solid fa-thumbs-up"></i></span>
                                    @else 
                                    <span class="msg_content">{{ $message->content }}</span>
                                    @endif
                                    {{-- <span class="btn_setting_chat left_btn_st"><i class="fa-solid fa-ellipsis"></i></span>
                                    <div class="show_setting_chat left_st hidden">
                                        <li data-id_message="{{$message->id}}" class="li_delete">
                                            <a href="">
                                                <span class="setting_icon"><i class="fa-solid fa-trash"></i></span>
                                                <span>Delete Message</span>
                                            </a>
                                        </li>
                                    </div> --}}
                                </div>
                            @else
                                <div id="big_message_from_{{$message->id_message}}" class="big_message_from">
                                    <div class="message_from setting_chat">
                                        <span class="btn_setting_chat right_btn_st"><i class="fa-solid fa-ellipsis"></i></span>
                                        <div class="show_setting_chat right_st hidden">
                                            <li data-id_message="{{$message->id_message}}" class="li_delete">
                                                <a href="">
                                                    <span class="setting_icon"><i class="fa-solid fa-trash"></i></span>
                                                    <span>Delete Message</span>
                                                </a>
                                            </li>
                                        </div>
                                        @if($message->content == '&&like&&')
                                        <span class="like_right"><i class="fa-solid fa-thumbs-up"></i></span>
                                        @else 
                                        <span class="msg_content">{{ $message->content }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif 
                        @endforeach
                    </div>
                </div>
                <div id="enter_message">
                    @if (\Illuminate\Support\Str::startsWith(auth()->guard('user')->user()->avatar, 'http'))
                        <img src="{{ auth()->guard('user')->user()->avatar }}">
                    @else
                        <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . auth()->guard('user')->user()->avatar }}">
                    @endif
                    <textarea data-id_from="{{auth()->guard('user')->user()->id}}" data-id_to="{{$user_to->id}}" type="text" class="form-control input_content inlineFormInputGroupChat"
                        placeholder="Enter a message"></textarea>
                    <span data-id_from="{{auth()->guard('user')->user()->id}}" data-id_to="{{$user_to->id}}" id="like_chat"><i class="fa-solid fa-thumbs-up"></i></span>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('blog/js/chat_frame.js') }}"></script>
@endsection
