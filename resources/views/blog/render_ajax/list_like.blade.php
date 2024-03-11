@if(isset($users) && count($users) > 0)
    <div id="title_like">There are {{count($users)}} people liking this article !
        <button style="outline: none" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @foreach($users as $index => $user)
        <div class="user_like">
            <a href="/main/personal-page/{{$user->id}}">
                @if (\Illuminate\Support\Str::startsWith($user->avatar, 'http'))
                    <img alt="Avatar" src="{{ $user->avatar }}">
                @else
                    <img alt="Avatar"
                        src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user->avatar }}">
                @endif
                <span>{{$user->name}}</span>
            </a>
            <span class="icon-heart"><i class="fa-solid fa-heart"></i></span>
        </div>
    @endforeach
@else 
    <div>The post has not been liked !
        <button style="outline: none" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
