<div data-id_to_user="{{$user_from->id}}" class="chatting" id="chatting_{{$user_from->id}}">
    <div>
        @if (\Illuminate\Support\Str::startsWith($user_from->avatar, 'http'))
            <img src="{{ $user_from->avatar }}">
        @else
            <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user_from->avatar }}">
        @endif
        <span class="user_online"><i class="fa-solid fa-circle"></i></span>
    </div>
    <div class="chatting_infor" id="div_content_{{$user_from->id}}">
        <p class="m-0 p-0">{{$user_from->name}}</p>
        @if($new_message->content == '&&like&&')
            <p id="p_content_{{$user_from->id}}" class="m-0 p-0 " style="font-weight: {{ $new_message->id_from != auth()->guard('user')->user()->id ? 'bold' : 'normal' }}">
                @if($new_message->id_from == auth()->guard('user')->user()->id) 
                    You : 
                @endif
                <i class="like_message fa-solid fa-thumbs-up"></i>
            </p>
        @else 
            <p style="font-weight: {{ $new_message->id_from != auth()->guard('user')->user()->id ? 'bold' : 'normal' }}" id="p_content_{{$user_from->id}}" class="m-0 p-0">
                @if($new_message->id_from == auth()->guard('user')->user()->id) 
                    You : 
                @endif
                {{$new_message->content}}
            </p>
        @endif
    </div>
</div>
<hr class="col-8 mx-auto" id="hr_chatting_{{$user_from->id}}">