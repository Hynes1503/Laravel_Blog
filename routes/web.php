<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DiscoverController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Admin\StatisticalController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\BlogOwnerMiddleware;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthorController;
// use App\Http\Controllers\PaymentController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin', function () {
        return redirect('/admin/dashboard');
    });
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware(AdminMiddleware::class);
    Route::get('/admin/statiscal', [StatisticalController::class, 'index'])->name('admin.statiscal.index');


    Route::get('/discover', [DiscoverController::class, 'index'])->name('discover.index');
    Route::get('/dashboard', [BlogController::class, 'index_dashboard'])->name('dashboard');
    Route::resource("blog", BlogController::class)/*->except(['edit'])*/;
    // Route::get('blog/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit')->middleware(BlogOwnerMiddleware::class);
});


Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/blog/{blog}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::post('/blog/{blog}/favorite', [FavoriteController::class, 'toggleFavorite'])->name('blog.favorite');
    Route::post('/blog/{blog}/share', [SocialAuthController::class, 'shareOnFacebook'])->name('blog.share');

    Route::get('/profile/{user_id}', [AuthorController::class, 'index'])->name('author.index');

    Route::get('/search', [SearchController::class, 'index'])->name('search');
});

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('redirect.facebook');
Route::get('auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

Route::post('/blogs/{blog}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');


// Route::post('/notifications/read', function (Request $request) {
//     $user = $request->user();
//     if ($user) {
//         $user->unreadNotifications->markAsRead();
//     }
//     return back();
// })->name('notifications.read');

Route::get('/home', function () {
    return view('home');
});

require __DIR__ . '/auth.php';
