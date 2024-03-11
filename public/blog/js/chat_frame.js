$(window).on('load', function () {
    animateScroll();
});
// $('#chat_box').on('mouseenter', function () {
//     $('#chat_box').stop();
// });
// $('#chat_box').on('mouseleave', function () {
//     animateScroll();
// });
function animateScroll() {
    console.log($('#chat_box').height());
    console.log($(document).height());
    $('#chat_box').animate({ scrollTop: 3000 }, 2000); // để hết 1s rồi cuộn thì nó sẽ không bị giựt 
}

// show setting chat 
$(document).ready(function() {
    $(document).on("click", function(event) {
        var target = $(event.target);
        if (!target.closest(".btn_setting_chat").length && !target.closest(".show_setting_chat").length) {
            $(".show_setting_chat").addClass("hidden");
        }
    });
    $('body').on('click', '.btn_setting_chat', function(event) {
        var $showSetting = $(this).next(".show_setting_chat");
        $showSetting.toggleClass("hidden");
        $(".btn_setting_chat").not(this).next(".show_setting_chat").addClass("hidden");
    });
});

// delete message 
$(document).ready(function() {
    $('body').on('click', '.li_delete', function(event) {
        event.preventDefault();
        var id_message = $(this).data('id_message');
        $.ajax({
            url: '/chat/ajax-delete-message',
            type: 'GET',
            data: {
                id_message: id_message,
            },
            success: function(response) {
                console.log(response);
                $('#big_message_from_' + id_message).remove();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
});


// new message 
$('body').on('keydown', '.inlineFormInputGroupChat', function(event) {
    if (event.which == 13) {
        event.preventDefault();
        var new_content_message = $(this).val();
        var id_from = $(this).data('id_from');
        var id_to = $(this).data('id_to');
        console.log(new_content_message, id_from, id_to);
        var textarea = $(this);
        if (new_content_message != '') {
            $.ajax({
                url: '/chat/ajax-add-message',
                type: 'GET',
                data: {
                    id_to: id_to,
                    id_from: id_from,
                    new_content_message: new_content_message
                },
                success: function(response) {
                    console.log(response);
                    $("#inner_box").append(response.new_message_html); 
                    $('#chat_box').animate({ scrollTop: 9999999 }, 1000); 
                    textarea.val('');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    }
});

// real time add and delete message
const pusher  = new Pusher('b60bd100db57d4ba49c1', {cluster: 'eu'});
const channel = pusher.subscribe('public');

// console.log(userId_notify);
//Receive messages
channel.bind('chat', function (data) {
  console.log('nhan',data);
    if(data.data.notify == 'add_message') {
        $.ajax({
            url:     "/chat/realtime-add-message",
            method:  'GET',
            headers: {
                'X-Socket-Id': pusher.connection.socket_id
            },
            data:    {
                _token:  '{{csrf_token()}}',
                id_new_message: data.data.id_new_message,
            }
        }).done(function (response) { 
            if(response.status == true) {
                if(response.id_from == $('#header_chat').data('id_user_to')) { // trường hợp 1 người chat với nhiều người trong nhiều tab cùng lúc 
                    if($("#big_message_from_"+response.id_message).length == 0){
                        $("#inner_box").append(response.new_message_html); 
                        $('#chat_box').animate({ scrollTop: 9999999 }, 1000); 
                    }
                }

                // chatting user 
                console.log(data.data.id_from);
                $('#chatting_' + response.id_from).remove();
                $('#hr_chatting_' + response.id_from).remove();
                $("#big_chatting").prepend(response.chatting_new_html); 
                $('#big_chatting').animate({ scrollTop: 0 }, 1000);
                console.log(data.data);

            }
            else {
                console.log(response.status, response.message);
            }
        });
    }
    if(data.data.notify == 'delete_message') {
        console.log(data.data.id_message);
        $('#big_message_from_' + data.data.id_message).remove();
        // $('#chat_box').animate({ scrollTop: 9999999 }, 1000); 

        $.ajax({
            url:     "/chat/realtime-delete-message",
            method:  'GET',
            headers: {
                'X-Socket-Id': pusher.connection.socket_id
            },
            data:    {
                _token:  '{{csrf_token()}}',
                id_from: data.data.id_from,
                id_to: data.data.id_to,
            }
        }).done(function (response) { 
            if(response.status == true) {
                // chatting user 
                console.log(data.data.id_from);
                $('#chatting_' + response.id_from).remove();
                $('#hr_chatting_' + response.id_from).remove();
                $("#big_chatting").prepend(response.chatting_delete_html); 
                $('#big_chatting').animate({ scrollTop: 0 }, 1000);
            }
            else {
                console.log(response.status, response.message);
            }
        });
    }
});

// like message 
$('body').on('click', '#like_chat', function(event) {
    var new_content_message = '&&like&&';
    var id_from = $(this).data('id_from');
    var id_to = $(this).data('id_to');
    console.log(new_content_message, id_from, id_to);
    var textarea = $(this);
    if (new_content_message != '') {
        $.ajax({
            url: '/chat/ajax-add-message',
            type: 'GET',
            data: {
                id_to: id_to,
                id_from: id_from,
                new_content_message: new_content_message
            },
            success: function(response) {
                console.log(response);
                $("#inner_box").append(response.new_message_html);
                $('#chat_box').animate({ scrollTop: 9999999 }, 1000); 
                textarea.val('');
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
});

// left chat 
$(document).ready(function() {
    $('#text_search').on('input', function() {
        var search_text = $(this).val();
        if (search_text != '') {
            $('#list_search').removeClass('hidden');
            $.ajax({
                url: '/chat/ajax-search-left',
                type: 'GET',
                data: {
                    search_text: search_text,
                },
                success: function(response) {
                    $('#inner_search').html(response.result_search);
                    console.log(response.result_search);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        } else $('#list_search').addClass('hidden');
    });
});

// goto personalPage
$('body').on('click', '.item_user', function(event) {
    idUser = $(this).data('id_user');
    window.location.href = "/chat/user/" + idUser;
});

// go to chat 
$(document).ready(function() {
    $('body').on('click', '.chatting', function(event) {
        var id_to_user = $(this).data("id_to_user");
        window.location.href = "/chat/user/" + id_to_user;
    });
});
