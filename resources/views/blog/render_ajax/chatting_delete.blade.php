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
        <p id="p_content_{{$user_from->id}}" class="m-0 p-0">
            @if($id_from == auth()->guard('user')->user()->id) 
                You
            @else 
                {{$user_from->name}}
            @endif
            have removed a message
        </p>
    </div>
</div>
<hr class="col-8 mx-auto" id="hr_chatting_{{$user_from->id}}">