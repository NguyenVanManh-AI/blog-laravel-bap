<div class="comment_article" id="comment_article_{{$comment->id}}">
    <div class="avatar_comment">
        @if(\Illuminate\Support\Str::startsWith($user->avatar, 'http'))
        <img alt="Avatar" src="{{ $user->avatar }}" >
        @else
            <img alt="Avatar" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user->avatar }}" >
        @endif
    </div>
    <div id="infor_comment_{{$comment->id}}" class="main_infor_comment" >
        <div class="infor_comment">
            <div class="infor_left">
                @if($comment->id_user == $article->id_user)
                <p class="author" ><i class="fa-solid fa-at"></i> Author</p>
                @endif
                <p class="infor_fullname_comment" data-id_user="{{$comment->id_user}}" >{{ $user->name }}</p>
                <p id="comment_content_{{$comment->id}}" class="comment_content infor_created_comment">{{ $comment->content }}</p>
            </div>
        </div>
        @if(auth()->guard('user')->check())
        <div class="setting_cmt" >
            <button class="btn_setting_cmt" ><i class="fa-solid fa-ellipsis" ></i></button>
            <div class="show_setting_cmt hidden" >
            @if($comment->id_user == auth()->guard('user')->user()->id)
            <li id="li_edit_{{$comment->id}}" class="li_edit li_edit_comment" ><span class="setting_icon"><i class="fa-solid fa-pen-to-square"></i></span> <span>Edit Comment</span></li>
            <li class="li_delete" id="li_delete_{{$comment->id}}" ><span class="setting_icon"><i class="fa-solid fa-trash"></i></span> <span>Delete Comment</span></li>
            @else 
            <li class="li_report" ><span class="setting_icon"><i class="fa-solid fa-flag"></i></span> <span>Report Comment</span></li>
            @endif
        </div>
        </div>
        @endif 
    </div>
    <div id="form_edit_{{$comment->id}}"  class="infor_comment hidden">
        <div class="infor_left">
            @if($comment->id_user == $article->id_user)
            <p class="author" ><i class="fa-solid fa-at"></i> Author</p>
            @endif
            <p class="infor_fullname_comment">{{ $user->name }}</p>
            <textarea id="textarea_{{$comment->id}}" class="edit_content" >{{$comment->content}}</textarea>
            <button class="btn_save" id="btn_save_{{$comment->id}}"><i class="fa-solid fa-check"></i> Save</button>
            <button class="btn_cancel" id="btn_cancel_{{$comment->id}}"><i class="fa-solid fa-xmark"></i> Cancel</button>
        </div>
    </div>
</div>