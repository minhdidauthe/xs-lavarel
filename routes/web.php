<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ShortcodeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\PageViewController;

// ─── Frontend (Lottery) ───
Route::get('/', [LotteryController::class, 'index']);
Route::get('/soi-cau', [LotteryController::class, 'prediction']);
Route::get('/thong-ke', [LotteryController::class, 'statistics']);
Route::get('/lich-su/{region?}', [LotteryController::class, 'history']);
Route::get('/quay-thu', [LotteryController::class, 'quayThu']);
Route::get('/bridge', [LotteryController::class, 'bridge']);
Route::get('/backend/bridge', [LotteryController::class, 'bridge']);

// ─── Authentication ───
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ─── Admin Panel ───
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin:admin,editor,writer'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class)->middleware('admin:admin,editor');
    Route::resource('tags', TagController::class)->middleware('admin:admin,editor');

    Route::resource('comments', CommentController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::patch('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::patch('comments/{comment}/spam', [CommentController::class, 'spam'])->name('comments.spam');

    Route::resource('pages', PageController::class)->middleware('admin:admin,editor');
    Route::resource('shortcodes', ShortcodeController::class)->middleware('admin:admin');
    Route::resource('users', UserController::class)->middleware('admin:admin');

    Route::post('upload/image', [UploadController::class, 'image'])->name('upload.image');
});

// ─── Public Blog ───
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/category/{slug}', [BlogController::class, 'category'])->name('category');
    Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('tag');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
    Route::post('/{slug}/comment', [BlogController::class, 'storeComment'])->name('comment.store');
});

// ─── Public Pages ───
Route::get('/page/{slug}', [PageViewController::class, 'show'])->name('page.show');
