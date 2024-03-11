$(document).ready(function() {
    $('#select_article').change(function() {
        var selected_value = $(this).val();
        $.ajax({
            url: "/admin/statistical-article",
            type: "GET",
            data: {
                selected_value: selected_value,
            },
            success: function(response) {
                console.log(response);
                $('#chart_bar_article').html(response.render_html);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
});

$(document).ready(function() {
    $('#select_comment').change(function() {
        var selected_value = $(this).val();
        $.ajax({
            url: "/admin/statistical-comment",
            type: "GET",
            data: {
                selected_value: selected_value,
            },
            success: function(response) {
                console.log(response);
                $('#chart_bar_comment').html(response.render_html);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
});

$(document).ready(function() {
    $('#select_user').change(function() {
        var selected_value = $(this).val();
        $.ajax({
            url: "/admin/statistical-user",
            type: "GET",
            data: {
                selected_value: selected_value,
            },
            success: function(response) {
                console.log(response);
                $('#chart_bar_user_line').html(response.render_html);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
});