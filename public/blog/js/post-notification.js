const pusher  = new Pusher('b60bd100db57d4ba49c1', {cluster: 'eu'});
const channel = pusher.subscribe('public');

// console.log(userId_notify);
//Receive messages
channel.bind('chat', function (data) {
  console.log('nhan',data);
    if(data.data.notify == 'add_cmt_like') {
        $.ajax({
            url:     "/notify/receive-add-cmt-like",
            method:  'GET',
            headers: {
                'X-Socket-Id': pusher.connection.socket_id
            },
            data:    {
                _token:  '{{csrf_token()}}',
                id_article: data.data.id_article,
                from: data.data.from,
                to: data.data.to,
                is_like: data.data.is_like,
                id_notify: data.data.id_notify,
            }
        }).done(function (response) { 
            if(response.status == true) {
                
                // c1
                // var currentNumber = parseInt($('#span_number_notify').text(), 10);
                // var newNumber = currentNumber + 1;
                // $('#span_number_notify').text(newNumber);
                // c1

                // $("#min_modal_content_notify").append(response.message); // vào cuối div 
                $("#min_modal_content_notify").prepend(response.message); // vào đầu div 
                $('#span_number_notify').text($(".link_notify").length); // c2 
                $('#min_modal_content_notify').animate({ scrollTop: 0 }, 1000);
            }
            else {
                console.log(response.status, response.message);
            }
        });
    }
    if(data.data.notify == 'un_like') {
        $('#notify_'+data.data.id_notify).remove();
        $('#span_number_notify').text($(".link_notify").length);
        $('#min_modal_content_notify').animate({ scrollTop: 0 }, 1000);
    }
});


// delete 
$('body').on('click', '.li_link_notify', function(event) {
    event.preventDefault();
    id_notify = $(this).data('id_notify');
    id_article = $(this).data('id_article');
    // console.log(id_notify, id_article);
    $.ajax({
        url: '/notify/delete-notify',
        type: 'GET',
        data: {
            id_notify: id_notify,
        },
        success: function(response) {
            console.log(response);
            window.location.href = "/main/article-details/" + id_article;
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
});
