<div id="big_message_from_{{$new_message->id}}" class="big_message_from">
    <div class="message_from setting_chat">
        <span class="btn_setting_chat right_btn_st"><i class="fa-solid fa-ellipsis"></i></span>
        <div class="show_setting_chat right_st hidden">
            <li data-id_message="{{$new_message->id}}" class="li_delete">
                <a href="">
                    <span class="setting_icon"><i class="fa-solid fa-trash"></i></span>
                    <span>Delete Message</span>
                </a>
            </li>
        </div>
        @if($new_message->content == '&&like&&')
        <span class="like_right"><i class="fa-solid fa-thumbs-up"></i></span>
        @else 
        <span class="msg_content">{{ $new_message->content }}</span>
        @endif
    </div>
</div>