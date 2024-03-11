@if($search_user || $search_article)
    <div class="item_user_article">
        @if($search_user)
            @foreach ($search_user as $user)
                <div class="item_user" data-id_user="{{$user->id}}">
                    @if(Str::startsWith($user->avatar, 'http')) 
                        <img alt="Avatar" src="{{ $user->avatar }}" >
                    @else 
                        <img alt="Avatar" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user->avatar }}" >
                    @endif
                    <span> {{ $user->name }} </span>
                </div>
            @endforeach
        @endif 
        @if($search_article)
            @foreach($search_article as $article)
                <div class="item_article" data-id_article="{{ $article->id }}" >
                    <i class="fa-solid fa-blog" style="margin-right: 8px;"></i> {{ $article->title }} </div>
            @endforeach
        @endif
    </div>
@endif
@if(count($search_user) == 0 && count($search_article) == 0)
    <div class="no_result"><i class="fa-solid fa-magnifying-glass"></i> No result</div>
@endif
