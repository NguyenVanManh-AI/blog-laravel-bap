<div class="link_notify" id="notify_{{$id_notify}}" >
    <a class="li_link_notify" href="/main/article-details/{{$article->id}}" data-id_notify="{{$id_notify}}" data-id_article="{{$article->id}}">
        <div class="big_notify">
            <div class="big_notify_img">
                @if (\Illuminate\Support\Str::startsWith($user->avatar, 'http'))
                    <img src="{{ $user->avatar }}">
                @else
                    <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user->avatar }}">
                @endif
                @if($is_like == 0)
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
                    <span>{{$user->name}}</span> đã 
                    @if($is_like == 0)
                    bình luận 
                    @else 
                    thích 
                    @endif 
                về bài viết của bạn : <span>{{$article->title}}</span>
                </p>   
                <p>{{ now()->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </a>
</div>