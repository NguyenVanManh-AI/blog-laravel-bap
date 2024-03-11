<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\LikedController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Admin page management
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => [],
], function () {
    // Example management
    Route::resource('examples', ExampleController::class);
    Route::get('something', [ExampleController::class, 'somethingMethod'])->name('something.get');

    // Other management
    // TODO: Handle route management
});

// Blog
// Auth
Route::get('login', [UserController::class, 'login'])->name('login');
Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('user-login', [UserController::class, 'userLogin'])->name('login.user');
Route::post('user-register', [UserController::class, 'userRegister'])->name('register.user');

// Forgot Password
Route::post('forgot-pw-sendcode', [UserController::class, 'forgotSend'])->name('forgot.sendcode');
Route::get('forgot-form', [UserController::class, 'forgotForm']);
Route::post('forgot-update', [UserController::class, 'forgotUpdate'])->name('forgot.update');

Route::middleware(['auth:user'])->group(function () {
    Route::get('dashboard', [UserController::class, 'dashboard']);
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});

// OAuth2
Route::get('authorized/google', [UserController::class, 'redirectToGoogle'])->name('google');
Route::get('authorized/google/callback', [UserController::class, 'handleGoogleCallback']);

Route::get('authorized/github', [UserController::class, 'redirectToGithub'])->name('github');
Route::get('authorized/github/callback', [UserController::class, 'handleGithubCallback']);

// Route::get('authorized/twitter', [CustomAuthController::class, 'redirectToTwitter']);
// Route::get('authorized/twitter/callback', [CustomAuthController::class, 'handleTwitterCallback']);

// Blog
Route::prefix('blog')->controller(ArticleController::class)->name('blog.')->group(function () {
    Route::middleware(['auth:user'])->group(function () {
        Route::get('/dashboard', 'dashboard');
        Route::get('/all', 'allArticle')->name('all');

        Route::get('/add', 'showAdd')->name('add');
        Route::get('/detail/{id}', 'showDetail')->name('show');
        Route::get('/edit/{id}', 'showEdit')->name('show_edit');
        Route::get('/my', 'myArticle')->name('my');

        Route::post('/add', 'addArticle')->name('add');
        Route::post('/update', 'updateArticle')->name('update');
        Route::post('/delete/{id}', 'deleteArticle')->name('delete');
        Route::get('/ajax-search', 'ajaxSearch')->name('search');
        Route::get('/ajax-search-my', 'ajaxSearchMy')->name('search_my');
    });
});

// Infor
Route::prefix('infor')->controller(UserController::class)->name('infor.')->group(function () {
    Route::middleware(['auth:user'])->group(function () {
        Route::get('/view-infor', 'viewInfor')->name('view_infor');
        Route::post('/update-infor', 'updateInfor')->name('update_infor');
        Route::post('/change-password', 'changePassword')->name('change_password');
    });
});

// Main
Route::prefix('main')->controller(CommentController::class)->name('main.')->group(function () {
    Route::get('/view', 'viewMain')->name('view_main');
    Route::get('/ajax-update-comment', 'updateComment')->name('update_comment');
    Route::get('/ajax-delete-comment', 'deleteComment')->name('delete_comment');
    Route::get('/ajax-add-comment', 'addComment')->name('add_comment');
    Route::get('/personal-page/{id_user}', 'personalPage')->name('personal_page');
    Route::get('/article-details/{id_article}', 'articleDetails')->name('article_details');
    Route::get('/ajax-search-left', 'searchLeft')->name('search_left');
});

// Liked
Route::prefix('liked')->controller(LikedController::class)->name('liked.')->group(function () {
    Route::get('/like-article', 'likeArticle')->name('like_article');
    Route::get('/ajax-list-like', 'listLike')->name('list_like');
});

// Admin
Route::prefix('admin')->controller(AdminController::class)->name('admin.')->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/admin-login', 'adminLogin')->name('post_login');
    Route::post('/admin-register', 'adminRegister')->name('post_register');

    // Forgot Password
    Route::post('forgot-pw-sendcode', 'forgotSend')->name('forgot_sendcode');
    Route::get('/forgot-form', 'forgotForm');
    Route::post('forgot-update', 'forgotUpdate')->name('forgot_update');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/view-infor', 'viewInfor')->name('view_infor');
        Route::post('/update-infor', 'updateInfor')->name('update_infor');
        Route::post('/change-password', 'changePassword')->name('change_password');

        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

        Route::get('/article', [ArticleController::class, 'allArticleAdmin'])->name('article');
        Route::get('/ajax-search-admin', [ArticleController::class, 'ajaxSearchAdmin'])->name('search_article');
        Route::post('/delete/{id}', [ArticleController::class, 'deleteArticleAdmin'])->name('delete_article');
        Route::get('/detail/{id}', [ArticleController::class, 'showDetailAdmin'])->name('show');

        Route::get('/comment', [CommentController::class, 'allCommentAdmin'])->name('comment');
        Route::get('/ajax-search-cmt-admin', [CommentController::class, 'ajaxSearchCmtAdmin'])->name('search_comment');
        Route::post('/delete-cmt/{id}', [CommentController::class, 'deleteCommentAdmin'])->name('delete_comment');

        Route::get('/user', [UserController::class, 'allUser'])->name('user');
        Route::get('/change-status', [UserController::class, 'changeStatus'])->name('change_status');
        Route::get('/ajax-search-user-admin', [UserController::class, 'ajaxSearchUserAdmin'])->name('search_user');

        Route::get('/all-admin', 'allAdmin')->name('all_admin');
        Route::get('/add-admin', 'addAdmin')->name('add_admin');
        Route::get('/change-role', 'changeRole')->name('change_role');
        Route::get('/ajax-search-infor-admin', 'ajaxSearchInforAdmin')->name('search_user');
        Route::post('/delete-admin/{id}', 'deleteAdmin')->name('delete_admin');

        Route::get('/statistical', 'statistical')->name('statistical');
        Route::get('/statistical-article', 'statisticalArticle')->name('statistical_article');
        Route::get('/statistical-comment', 'statisticalComment')->name('statistical_comment');
        Route::get('/statistical-user', 'statisticalUser')->name('statistical_user');
    });
});

// Notify
Route::prefix('notify')->controller(NotifyController::class)->name('notify.')->group(function () {
    Route::get('/receive-add-cmt-like', 'receiveAddCmtLike')->name('receive_add_cmt_like');
    Route::get('/delete-notify', 'deleteNotify')->name('delete_notify');
});

// Chat
Route::prefix('chat')->controller(MessageController::class)->name('chat.')->group(function () {
    Route::middleware(['auth:user'])->group(function () {
        Route::get('/user/{id}', 'viewChat')->name('view_chat');
        Route::get('/ajax-delete-message', 'deleteMessage')->name('delete_message');
        Route::get('/ajax-add-message', 'addMessage')->name('add_message');
        Route::get('/realtime-add-message', 'realtimeAddMessage')->name('realtime_add_message');
        Route::get('/realtime-delete-message', 'realtimeDelMessage')->name('realtime_delete_message');
        Route::get('/ajax-search-left', 'searchLeft')->name('search_left');
    });
});
