$(document).ready(function() {
    $('#search').on('input', function() {
        var search = $(this).val();
        $.ajax({
            url: "/admin/ajax-search-cmt-admin",
            type: "GET",
            data: {
                search: search
            },
            success: function(response) {
                $('#body-article').html(response.render_html);
                $('#pagination_container').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var search = $('#search').val();
        var url = '/admin/ajax-search-cmt-admin?page=' + page

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                search: search
            },
            success: function(response) {
                $('#body-article').html(response.render_html);
                $('#pagination_container').html(response.pagination);
            }
        });
    });
});