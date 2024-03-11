@if($search_user)
    <div class="item_user_article">
        @if($search_user)
            @foreach ($search_user as $user)
                @if($user->id != auth()->guard('user')->user()->id)
                <div class="item_user" data-id_user="{{$user->id}}">
                    @if(Str::startsWith($user->avatar, 'http')) 
                        <img alt="Avatar" src="{{ $user->avatar }}" >
                    @else 
                        <img alt="Avatar" src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user->avatar }}" >
                    @endif
                    <span> {{ $user->name }} </span>
                </div>
                @endif
            @endforeach
        @endif 
    </div>
@endif
@if(count($search_user) == 0)
    <div class="no_result"><i class="fa-solid fa-magnifying-glass"></i> No result</div>
@endif
