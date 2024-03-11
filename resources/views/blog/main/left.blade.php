<link rel="stylesheet" href="{{ asset('blog/css/main/left.css') }}">
<div id="dashboard_left">
    <div class="main_right col-12 d-flex pb-3" >
        <div class="logo_blog" ><img src="{{asset('Blog/image/logo.png')}}"/></div>
        <div class="form_search">
            <div class="input-group">
                <input type="text" class="shadow-none form-control" id="text_search" placeholder="Search name or title article">
                <div class="input-group-prepend">
                    <div class="input-group-text" ><i class="fa-solid fa-magnifying-glass"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row hidden" id="list_search" >
        <div class="col-12 p-1" id="inner_search">
        </div>
    </div>
</div>
<script src="{{asset('blog/js/left.js')}}"></script>
