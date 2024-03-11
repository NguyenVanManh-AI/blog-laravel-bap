<link rel="stylesheet" href="{{ asset('blog/css/main/right.css') }}">
<div id="right_min" >
    @if(auth()->guard('user')->check())
        <div id="show_modal" >
            <div id="notify" data-toggle="modal" data-target="#modalNotifi">
                <span id="icon"><i class="fa-solid fa-bell"></i></span>
                <div id="number_notify"><span id="span_number_notify">{{count($notifys)}}</span></div>
            </div>
            <span data-toggle="modal" data-target="#modalUser">{{auth()->guard('user')->user()->name}}</span> 
            @if(\Illuminate\Support\Str::startsWith(auth()->guard('user')->user()->avatar, 'http'))
                <img data-toggle="modal" data-target="#modalUser" id="upload_img" src="{{ auth()->guard('user')->user()->avatar }}" >
            @else
                <img data-toggle="modal" data-target="#modalUser" id="upload_img" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . auth()->guard('user')->user()->avatar }}" >
            @endif
        </div>
        <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div id="modal_content" class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background-color: transparent;border: none;">
                    <div id="outner_modal">
                        <div id="min_modal_content">
                            <a href="{{ route('main.personal_page', ['id_user' => auth()->guard('user')->user()->id]) }}"><span><i class="fa-solid fa-user-check"></i></span>{{auth()->guard('user')->user()->name}}</a>
                            <a href="{{ route('infor.view_infor') }}"><span><i class="fa-solid fa-gear"></i></span> Personal page </a>
                            <a href=""><span><i class="fa-solid fa-question"></i></span> Help & Support </a>
                            <a href=""><span><i class="fa-solid fa-info"></i></span> Comments </a>
                            <a href="{{ route('logout') }}" ><span><i class="fa-solid fa-arrow-right-from-bracket"></i></span> Log out </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else 
    <div id="show_modal" data-toggle="modal" data-target="#modalUser">
        <a href="{{ route('login') }}" style="border-radius: 10px" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Login</a>
    </div>
    @endif 
</div>
<div style="background-color: transparent !important; " class="modal fade" id="modalNotifi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div id="modal_content" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: transparent !important ;border: none;">
            <div id="outner_modal" >
                <div id="min_modal_content_notify">
                    @if($notifys)
                        @foreach($notifys as $index => $notify)
                            <div class="link_notify" id="notify_{{$notify->id_notify}}">
                                <a class="li_link_notify" href="/main/article-details/{{$notify->id_article}}" data-id_notify="{{$notify->id_notify}}" data-id_article="{{$notify->id_article}}">
                                    <div class="big_notify">
                                        <div class="big_notify_img">
                                            @if (\Illuminate\Support\Str::startsWith($notify->avatar, 'http'))
                                                <img src="{{ $notify->avatar }}">
                                            @else
                                                <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $notify->avatar }}">
                                            @endif
                                            @if($notify->is_like == 0)
                                                <span class="notify_cmt_sp">
                                                    <i class="fa-solid fa-comment"></i>
                                                </span>
                                            @else 
                                                <span class="notify_like_sp">
                                                    <i class="fa-solid fa-heart"></i>
                                                </span> 
                                            @endif 
                                        </div>
                                        <div class="big_notify_ms">
                                            <p>
                                                <span>{{$notify->name}}</span> đã 
                                                @if($notify->is_like == 0)
                                                bình luận 
                                                @else 
                                                thích 
                                                @endif 
                                            về bài viết của bạn : <span>{{$notify->title}}</span>
                                            </p>   
                                            <p>{{$notify->created_at}}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var userId_notify = {{ auth()->guard('user')->user() ? auth()->guard('user')->user()->id : 'null' }};
 </script>
<script src="{{ asset('blog/js/post-notification.js') }}"></script>
