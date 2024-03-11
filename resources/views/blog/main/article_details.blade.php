@extends('Blog.Layouts.Master')
@section('content')
    <link rel="stylesheet" href="{{ asset('blog/css/main/article_details.css') }}">
    <div id="big_main">
        <div id="left_main">
            @include('blog.main.left')
        </div>
        <div id="middle_main">
            <link rel="stylesheet" href="{{ asset('blog/css/middle.css') }}">
            <link rel="stylesheet" href="{{ asset('blog/css/article-details.css') }}">
            <div id="dashboard_user">
                @foreach ($articles as $key => $article)
                    <div class="big_article">
                        <div class="header_article">
                            <div class="avatar_article">
                                @if (\Illuminate\Support\Str::startsWith($article->avatar, 'http'))
                                    <img alt="Avatar" src="{{ $article->avatar }}">
                                @else
                                    <img alt="Avatar" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $article->avatar }}">
                                @endif
                            </div>
                            <div class="infor_article">
                                <div class="infor_left">
                                    <p class="infor_fullname" data-id_user="{{ $article->id_user }}">{{ $article->name }}
                                    </p>
                                    <p class="infor_created" data-id_article="{{ $article->id_article }}">
                                        {{ $article->created_at }}</p>
                                </div>
                                @if (auth()->guard('user')->check())
                                    <div class="infor_right">
                                        <button class="btn_setting"><i class="fa-solid fa-ellipsis"></i></button>
                                        <div class="show_setting hidden">
                                            @if ($article->id_user == auth()->guard('user')->user()->id)
                                                <li class="li_edit"><a
                                                        href="{{ route('blog.show_edit', ['id' => $article->id_article]) }}"><span
                                                            class="setting_icon"><i class="fa-solid fa-pen-nib"></i></span>
                                                        <span>Edit Article</span></a></li>
                                                <li class="li_delete" data-toggle="modal" data-target="#exampleModalDelete">
                                                    <form method="POST"
                                                        action="{{ route('blog.delete', $article->id_article) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this article?');">
                                                        @csrf
                                                        <button><span class="setting_icon"><i
                                                                    class="fa-solid fa-trash"></i></span> <span>Delete
                                                                Article</span></button>
                                                    </form>
                                                </li>
                                            @else
                                                <li class="li_save"><span class="setting_icon"><i
                                                            class="fa-solid fa-bookmark"></i></span> <span>Save
                                                        Articlee</span></li>
                                                <li class="li_unfollow"><span class="setting_icon"><i
                                                            class="fa-solid fa-user-xmark"></i></span> <span>Unfollow</span>
                                                </li>
                                                <li class="li_report"><span class="setting_icon"><i
                                                            class="fa-solid fa-flag"></i></span> <span>Report Article</span>
                                                </li>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="content_main_article">
                            <div class="main_title" data-toggle="modal"
                                data-target="#modalArticleDetail_{{ $article->id_article }}">
                                <i class="fa-solid fa-play mr-2"></i>{{ $article->title }}
                            </div>
                            <div class="main_center">
                                <i class="fa-solid fa-blog"></i>
                            </div>
                            <div>
                                <div>{!! $article->content !!}</div>
                            </div>
                        </div>
                        <div class="footer_article">
                            <div class="footer_number_comment ajax_load_article">
                                @if(isset($article->user_likes))
                                    <div class="openModalLike" data-id_article="{{$article->id_article}}" data-toggle="modal" data-target="#modalLike" id="infor_like_{{ $article->id_article }}">
                                        <span id="number_like_{{ $article->id_article }}" class="number_user_like">{{ count(json_decode($article->user_likes)) }} Like</span>  
                                        @foreach($article->arr_user_likes as $index => $user_like)
                                            @if(auth()->guard('user')->check() && (auth()->guard('user')->user()->id == $user_like->id))
                                            <div id="my_like_{{ $article->id_article }}" class="avatar_user_like">
                                                @if (\Illuminate\Support\Str::startsWith($user_like->avatar, 'http'))
                                                    <img alt="Avatar" src="{{ $user_like->avatar }}">
                                                @else
                                                    <img alt="Avatar" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user_like->avatar }}">
                                                @endif
                                            </div>
                                            @else
                                                <div class="avatar_user_like">
                                                    @if (\Illuminate\Support\Str::startsWith($user_like->avatar, 'http'))
                                                        <img alt="Avatar" src="{{ $user_like->avatar }}">
                                                    @else
                                                        <img alt="Avatar" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user_like->avatar }}">
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else 
                                    <div class="openModalLike" data-id_article="{{$article->id_article}}" data-toggle="modal" data-target="#modalLike" id="infor_like_{{ $article->id_article }}">
                                        <span id="number_like_{{ $article->id_article }}" class="number_user_like">0 Like</span>  
                                    </div>
                                @endif
                                <div class="ajax_load_article" id="number_comment_{{ $article->id_article }}" data-id_article="{{ $article->id_article }}" data-toggle="modal"
                                    data-target="#modalArticleDetail_{{ $article->id_article }}">
                                    {{ count($article->comments) }} Comments
                                </div>
                            </div>
                            <div class="footer_comment_article">
                                @if(auth()->guard('user')->check())
                                    @if(isset($article->user_likes) && in_array(auth()->guard('user')->user()->id, json_decode($article->user_likes)))
                                    <div onclick="likeArticle(this)" class="liked ajax_load_article like_article" data-id_article="{{ $article->id_article }}" >
                                        <span><i class="fa-solid fa-heart"></i></span> <span>Like</span>
                                    </div>
                                    @else
                                    <div onclick="likeArticle(this)" class="ajax_load_article like_article" data-id_article="{{ $article->id_article }}" >
                                        <span><i class="fa-regular fa-heart"></i></span> <span>Like</span>
                                    </div>
                                    @endif
                                @endif
                                <div class="ajax_load_article" data-id_article="{{ $article->id_article }}" data-toggle="modal"
                                    data-target="#modalArticleDetail_{{ $article->id_article }}"><span><i
                                            class="fa-regular fa-message"></i></span> <span>Comments</span></div>
                                <div class="ajax_load_article" data-id_article="{{ $article->id_article }}" data-toggle="modal"
                                    data-target="#modalArticleDetail_{{ $article->id_article }}"><span><i
                                            class="fa-regular fa-eye"></i></span> <span>View Details</span></div>
                            </div>
                        </div>
                        <div class="list_comment" id="list_comment_{{ $article->id_article }}">
                            @foreach ($article->comments as $key => $comment)
                                <div class="comment_article" id="comment_article_{{ $comment->id_comment }}">
                                    <div class="avatar_comment">
                                        @if (\Illuminate\Support\Str::startsWith($comment->avatar, 'http'))
                                            <img alt="Avatar" src="{{ $comment->avatar }}">
                                        @else
                                            <img alt="Avatar" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $comment->avatar }}">
                                        @endif
                                    </div>
                                    <div id="infor_comment_{{ $comment->id_comment }}" class="main_infor_comment">
                                        <div class="infor_comment">
                                            <div class="infor_left">
                                                @if ($comment->id_user == $article->id_user)
                                                    <p class="author"><i class="fa-solid fa-at"></i> Author</p>
                                                @endif
                                                <p class="infor_fullname_comment" data-id_user="{{ $comment->id_user }}">
                                                    {{ $comment->name }}</p>
                                                <p id="comment_content_{{ $comment->id_comment }}"
                                                    class="comment_content infor_created_comment">{{ $comment->content }}
                                                </p>
                                            </div>
                                        </div>
                                        @if (auth()->guard('user')->check())
                                            <div class="setting_cmt">
                                                <button class="btn_setting_cmt"><i
                                                        class="fa-solid fa-ellipsis"></i></button>
                                                <div class="show_setting_cmt hidden">
                                                    @if ($comment->id_user == auth()->guard('user')->user()->id)
                                                        <li id="li_edit_{{ $comment->id_comment }}"
                                                            class="li_edit li_edit_comment"><span class="setting_icon"><i
                                                                    class="fa-solid fa-pen-to-square"></i></span> <span>Edit
                                                                Comment</span></li>
                                                        <li class="li_delete" id="li_delete_{{ $comment->id_comment }}">
                                                            <span class="setting_icon"><i
                                                                    class="fa-solid fa-trash"></i></span> <span>Delete
                                                                Comment</span></li>
                                                    @else
                                                        <li class="li_report"><span class="setting_icon"><i
                                                                    class="fa-solid fa-flag"></i></span> <span>Report
                                                                Comment</span></li>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div id="form_edit_{{ $comment->id_comment }}" class="infor_comment hidden">
                                        <div class="infor_left">
                                            @if ($comment->id_user == $article->id_user)
                                                <p class="author"><i class="fa-solid fa-at"></i> Author</p>
                                            @endif
                                            <p class="infor_fullname_comment">{{ $comment->name }}</p>
                                            <textarea id="textarea_{{ $comment->id_comment }}" class="edit_content">{{ $comment->content }}</textarea>
                                            <button class="btn_save" id="btn_save_{{ $comment->id_comment }}"><i
                                                    class="fa-solid fa-check"></i> Save</button>
                                            <button class="btn_cancel" id="btn_cancel_{{ $comment->id_comment }}"><i
                                                    class="fa-solid fa-xmark"></i> Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if (auth()->guard('user')->check())
                            <div id="add_comment">
                                <div class="header_comment ">
                                    <div class="avatar_article">
                                        @if (\Illuminate\Support\Str::startsWith(auth()->guard('user')->user()->avatar, 'http'))
                                            <img alt="Avatar" src="{{ auth()->guard('user')->user()->avatar }}">
                                        @else
                                            <img alt="Avatar"
                                                src="{{ \App\Enums\UserEnum::DOMAIN_PATH . auth()->guard('user')->user()->avatar }}">
                                        @endif
                                    </div>
                                    <div class="send_content_comment">
                                        <div>
                                            <div class="input-group">
                                                <form>
                                                    <textarea style="background-color: #F0F2F5" type="text" class="form-control input_content inlineFormInputGroup"
                                                        placeholder="Write a comment..."></textarea>
                                                    <p
                                                        style="font-size: 12px;padding-left: 6px;color: #515151;margin-top: 2px;">
                                                        Tip : Press the key combination <span style="font-weight: bold;"><i
                                                                class="fa-brands fa-windows"></i> + .</span> for more icons
                                                        . For Mac OS, press <span style="font-weight: bold;">Command +
                                                            Control + Space</span> .</p>
                                                </form>
                                                <style>
                                                    .input_content {
                                                        width: 45vw;
                                                    }
                                                </style>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
                <!-- Modal Like -->
                <div class="modal fade " style="background-color: #3d3d3d99 !important" id="modalLike" tabindex="-1" role="dialog" aria-labelledby="modalLike" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body" id="body-list-like">
                        ...
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <script src="{{ asset('blog/js/article-details.js') }}"></script>
        </div>
        <div id="right_main">
            @include('blog.main.right')
        </div>
        <style>
            #toTop {
                position: fixed !important;
                bottom: 30px !important;
            }
        </style>
        <div id="toTop" v-if="showButton"><i class="fa-solid fa-chevron-up"></i></div>
        <script>
            $('.logo_blog').on('click', function() {
                window.location.href = "/main/view";
            });
            var btn = $('#button');
            $('#toTop').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, '300');
                $('#dashboard_user').animate({
                    scrollTop: 0
                }, '300');
            });
        </script>
    </div>
@endsection
