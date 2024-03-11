$(document).ready(function() {
    $('#search').on('input', function() {
        var search = $(this).val();
        var role = $('#search-role').val();
        var per_page = $('#per_page').val();
    
        var currentURL = new URL(window.location.href);
        currentURL.searchParams.delete('search');
        currentURL.searchParams.append('search', search);
        history.pushState({}, '', currentURL.href);

        currentURL.searchParams.delete('page');
        currentURL.searchParams.append('page', 1);
        history.pushState({}, '', currentURL.href);

        $.ajax({
            url: "/admin/ajax-search-infor-admin",
            type: "GET",
            data: {
                search: search,
                page: 1,
                role: role,
                per_page: per_page,
            },
            success: function(response) {
                $('#body-admin').html(response.render_html);
                $('#pagination_container').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    $(document).on('change', '#search-role', function(event) {
        var search = $('#search').val();
        var role = $('#search-role').val();
        var per_page = $('#per_page').val();

        var currentURL = new URL(window.location.href);
        currentURL.searchParams.delete('role');
        currentURL.searchParams.append('role', role);
        history.pushState({}, '', currentURL.href);

        currentURL.searchParams.delete('page');
        currentURL.searchParams.append('page', 1);
        history.pushState({}, '', currentURL.href);

        $.ajax({
            url: "/admin/ajax-search-infor-admin",
            type: "GET",
            data: {
                search: search,
                role: role,
                per_page: per_page,
                page: 1,
            },
            success: function(response) {
                $('#body-admin').html(response.render_html);
                $('#pagination_container').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    $(document).on('change', '#per_page', function(event) {
        var search = $('#search').val();
        var per_page = $('#per_page').val();
        var role = $('#search-role').val();

        var currentURL = new URL(window.location.href);
        currentURL.searchParams.delete('per_page');
        currentURL.searchParams.append('per_page', per_page);
        history.pushState({}, '', currentURL.href);

        $.ajax({
            url: "/admin/ajax-search-infor-admin",
            type: "GET",
            data: {
                search: search,
                role: role,
                per_page: per_page,
            },
            success: function(response) {
                $('#body-admin').html(response.render_html);
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
        var role = $('#search-role').val();
        var per_page = $('#per_page').val();
        var url = '/admin/ajax-search-infor-admin?page=' + page

        var currentURL = new URL(window.location.href);
        currentURL.searchParams.delete('page');
        currentURL.searchParams.append('page', page);
        history.pushState({}, '', currentURL.href);

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                search: search,
                role: role,
                per_page: per_page,
            },
            success: function(response) {
                $('#body-admin').html(response.render_html);
                $('#pagination_container').html(response.pagination);
            }
        });
    });

    $(document).on('change', '.role-admin', function(event) {
        var selectedValue = $(this).val();
        var idAdmin = $(this).data('id_admin');
        $.ajax({
            url: "/admin/change-role",
            method: 'GET',
            data: {
                id_admin: idAdmin,
                role: selectedValue,
            },
            success: function(response) {
                $(function(){
                    $("#change_admin_"+idAdmin).remove();
                    $("#del_admin_"+idAdmin).remove();
                    toastr.success('Change Role Success !');
                })
                console.log(response);
            },
            error: function(xhr, status, error) {
                $(function(){
                    toastr.error('Change Role Fail !');
                })
                console.log(error);
            }
        });
    });
});