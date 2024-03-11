$(document).ready(function() {
    $('#search').on('input', function() {
        var search = $(this).val();
        var block = $('#search-block').val();
        var per_page = $('#per_page').val();

        var currentURL = new URL(window.location.href);
        currentURL.searchParams.delete('search');
        currentURL.searchParams.append('search', search);
        history.pushState({}, '', currentURL.href);

        $.ajax({
            url: "/admin/ajax-search-user-admin",
            type: "GET",
            data: {
                search: search,
                block: block,
                per_page: per_page,
            },
            success: function(response) {
                $('#body-user').html(response.render_html);
                $('#pagination_container').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    $(document).on('change', '#search-block', function(event) {
        var search = $('#search').val();
        var block = $('#search-block').val();
        var per_page = $('#per_page').val();

        var currentURL = new URL(window.location.href);
        currentURL.searchParams.delete('block');
        currentURL.searchParams.append('block', block);
        history.pushState({}, '', currentURL.href);

        currentURL.searchParams.delete('page');
        currentURL.searchParams.append('page', 1);
        history.pushState({}, '', currentURL.href);

        $.ajax({
            url: "/admin/ajax-search-user-admin",
            type: "GET",
            data: {
                search: search,
                block: block,
                per_page: per_page,
                page: 1,
            },
            success: function(response) {
                $('#body-user').html(response.render_html);
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
        var url = '/admin/ajax-search-user-admin?page=' + page
        var block = $('#search-block').val();
        var per_page = $('#per_page').val();

        var currentURL = new URL(window.location.href);
        currentURL.searchParams.delete('page');
        currentURL.searchParams.append('page', page);
        history.pushState({}, '', currentURL.href);

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                search: search,
                block: block,
                per_page: per_page,
            },
            success: function(response) {
                $('#body-user').html(response.render_html);
                $('#pagination_container').html(response.pagination);
            }
        });
    });

    $(document).on('change', '#per_page', function(event) {
        var search = $('#search').val();
        var per_page = $('#per_page').val();
        var block = $('#search-block').val();

        var currentURL = new URL(window.location.href);
        currentURL.searchParams.delete('per_page');
        currentURL.searchParams.append('per_page', per_page);
        history.pushState({}, '', currentURL.href);

        $.ajax({
            url: "/admin/ajax-search-user-admin",
            type: "GET",
            data: {
                search: search,
                block: block,
                per_page: per_page,
            },
            success: function(response) {
                $('#body-user').html(response.render_html);
                $('#pagination_container').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });


    $(document).on('click', '.button-6 .checkbox', function(event) {
        var id = $(this).data('id_user');
        // var currentStatus = $(this).data('status');
        // var newStatus = currentStatus === 1 ? 0 : 1;
        // $(this).data('status', newStatus);
        
        $.ajax({
            url: "/admin/change-status",
            method: 'GET',
            data: {
                id_user: id,
                // status: currentStatus,
            },
            success: function(response) {
                $(function(){
                    toastr.success('Change Status Success !');
                })
                console.log(response);
            },
            error: function(xhr, status, error) {
                $(function(){
                    toastr.error('Change Status Fail !');
                })
                console.log(error);
            }
        });
    });
});