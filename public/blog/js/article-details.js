var url = window.location.pathname;
var parts = url.split('/');
var id_article = parts[parts.length - 1];

// show setting article 
$(document).ready(function() {
    $(document).on("click", function(event) {
        var target = $(event.target);
        if (!target.closest(".btn_setting").length && !target.closest(".show_setting").length) {
            $(".show_setting").addClass("hidden");
        }
    });
    $(".btn_setting").on("click", function() {
        var $showSetting = $(this).next(".show_setting");
        $showSetting.toggleClass("hidden");
        $(".btn_setting").not(this).next(".show_setting").addClass("hidden");
    });
});

// show setting comment  
$(document).ready(function() {
    $(document).on("click", function(event) {
        var target = $(event.target);
        if (!target.closest(".btn_setting_cmt").length && !target.closest(".show_setting_cmt").length) {
            $(".show_setting_cmt").addClass("hidden");
        }
    });
});
$('body').on('click', '.btn_setting_cmt', function(e) {
    var $showSetting = $(this).next(".show_setting_cmt");
    $showSetting.toggleClass("hidden");
    $(".btn_setting_cmt").not(this).next(".show_setting_cmt").addClass("hidden");
});

// ẩn hiện form edit comment 
$('body').on('click', '.li_edit_comment', function(e) {
    var str = $(this).attr('id');
    var parts = str.split('_');
    var id_comment = parts[2];
    $('#infor_comment_' + id_comment + ', #form_edit_' + id_comment).toggleClass('hidden');
    $('#textarea_' + id_comment).val($('#comment_content_' + id_comment).html());
});

// cancel edit 
$('body').on('click', '.btn_cancel', function(e) {
    var str = $(this).attr('id');
    var parts = str.split('_');
    var id_comment = parts[2];
    $('#infor_comment_' + id_comment + ', #form_edit_' + id_comment).toggleClass('hidden');
});

// btn save 
$('body').on('click', '.btn_save', function(e) {
    var str = $(this).attr('id');
    var parts = str.split('_');
    var id_comment = parts[2];
    var new_content_comment = $('#textarea_' + id_comment).val();
    $.ajax({
        url: '/main/ajax-update-comment',
        type: 'GET',
        data: {
            id_comment: id_comment,
            new_content_comment: new_content_comment
        },
        success: function(response) {
            // Xử lý kết quả thành công
            console.log(response);
        },
        error: function(xhr) {
            // Xử lý lỗi
            console.log(xhr.responseText);
        }
    });
    $('#comment_content_' + id_comment).html(new_content_comment);
    $('#infor_comment_' + id_comment + ', #form_edit_' + id_comment).toggleClass('hidden');
});

// set number comment 
function addComment() {
    var str = $('#number_comment_' + id_article).html();
    var number = parseInt(str);
    number = number + 1;
    $('#number_comment_' + id_article).html(number + ' Comments');
}

function deleteComment() {
    var str = $('#number_comment_' + id_article).html();
    var number = parseInt(str);
    number = number - 1;
    $('#number_comment_' + id_article).html(number + ' Comments');
}

// delete 
$('body').on('click', '.li_delete', function(e) {
    var str = $(this).attr('id');
    var parts = str.split('_');
    var id_comment = parts[2];
    $.ajax({
        url: '/main/ajax-delete-comment',
        type: 'GET',
        data: {
            id_comment: id_comment
        },
        success: function(response) {
            console.log(response);
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
    deleteComment();
    $('#comment_article_' + id_comment).addClass('hidden');
});

$('body').on('keydown', '.inlineFormInputGroup', function(event) {
    if (event.which == 13) {
        event.preventDefault();
        var new_content_comment = $(this).val();
        if (new_content_comment != '') {
            $.ajax({
                url: '/main/ajax-add-comment',
                type: 'GET',
                data: {
                    id_article: id_article,
                    new_content_comment: new_content_comment
                },
                success: function(response) {
                    $("#list_comment_" + id_article).append(response.comment_element);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
            addComment();
        }
        $(this).val('');
    }
});

// goto personalPage
$('.infor_fullname').on('click', function() {
    idUser = $(this).data('id_user');
    window.location.href = "/main/personal-page/" + idUser;
});

$('body').on('click', '.infor_fullname_comment', function(event) {
    idUser = $(this).data('id_user');
    window.location.href = "/main/personal-page/" + idUser;
});

// goto Article Details 
$('.infor_created').on('click', function() {
    idArticle = $(this).data('id_article');
    window.location.href = "/main/article-details/" + idArticle;
});

// like
function likeArticle(x) {
    x.classList.toggle("liked");
    var heartIcon = x.querySelector("i");
    heartIcon.classList.toggle("fa-regular");
    heartIcon.classList.toggle("fa-solid");

    var id_article = $(x).data('id_article');
    var heartIcon = $(x).find("i");
    var is_like = 0;
    if (heartIcon.hasClass("fa-regular")) {
        is_like = 0;

        var str = $('#number_like_' + id_article).html();
        var number = parseInt(str);
        number = number - 1;
        $('#number_like_' + id_article).html(number + ' Like');

        $('#my_like_'+id_article).remove();
        $.ajax({
            url: '/liked/like-article',
            type: 'GET',
            data: {
                id_article: id_article,
                is_like: is_like
            },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
    else {
        is_like = 1;

        var str = $('#number_like_' + id_article).html();
        var number = parseInt(str);
        number = number + 1;
        $('#number_like_' + id_article).html(number + ' Like');

        $.ajax({
            url: '/liked/like-article',
            type: 'GET',
            data: {
                id_article: id_article,
                is_like: is_like
            },
            success: function(response) {
                $("#infor_like_" + id_article).append(response.render_html);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

}

$('body').on('click', '.openModalLike', function(event) {
    var id_article = $(this).data('id_article');
    $.ajax({
        url: '/liked/ajax-list-like',
        type: 'GET',
        data: {
            id_article: id_article,
        },
        success: function(response) {
            $('#body-list-like').html(response.render_html);
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });

});
