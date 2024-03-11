<div id="big_message_from_{{$new_message->id}}" class="message_to setting_chat" >
    @if (\Illuminate\Support\Str::startsWith($user_from->avatar, 'http'))
        <img src="{{ $user_from->avatar }}">
    @else
        <img src="{{ \App\Enums\UserEnum::DOMAIN_PATH . $user_from->avatar }}">
    @endif
    @if($new_message->content == '&&like&&')
    <span class="like_left"><i class="fa-solid fa-thumbs-up"></i></span>
    @else 
    <span class="msg_content">{{ $new_message->content }}</span>
    @endif
</div>