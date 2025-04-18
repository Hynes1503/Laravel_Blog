<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\BlogOwnerMiddleware;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Admin\StatisticalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\AdminBlogStatsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\GeminiController;

Route::middleware(['auth', 'verified', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });
    Route::get('/pages', [PageController::class, 'index'])->name('admin.pages.index');
    Route::get('/pages/{page}', [PageController::class, 'edit'])->name('admin.pages.edit');
    Route::patch('/pages/{page}', [PageController::class, 'update'])->name('admin.pages.update');

    Route::get('/statiscal', [StatisticalController::class, 'index'])->name('admin.blog-stats');
    // Route::get('/statiscal', [StatisticalController::class, 'index'])->name('admin.statiscal.index');
    Route::get('/blog-stats', [AdminBlogStatsController::class, 'index'])->name('blog-stats');
    Route::resource('categories', AdminCategoryController::class);
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('blog', AdminBlogController::class)->names('admin.blog');
    Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('/user/{user_id}', [UserController::class, 'index_author'])->name('admin.user.show');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('admin.user.update');
    Route::get('/user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/user', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('/register-user', [UserController::class, 'create'])->name('admin.user.create');
    Route::get('/search-blog', [SearchController::class, 'admin_blog_index'])->name('admin.blog.search');
    Route::get('/search-category', [SearchController::class, 'admin_category_index'])->name('admin.category.search');
    Route::get('/search-user', [SearchController::class, 'admin_user_index'])->name('admin.user.search');
    Route::get('/comments', [CommentController::class, 'index'])->name('admin.comment.index');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notification.index');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('admin.notification.markAsRead');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('admin.notification.destroy');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notification.markAllAsRead');
    Route::delete('/destroy-all-noti', [NotificationController::class, 'destroyAll'])->name('admin.notification.destroyAll');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/user/{user}/report', [UserController::class, 'report'])->name('user.report');
    Route::get('/category/{id}', [CategoryController::class, 'index'])->name('user.category.index');
    Route::get('/discover', [DiscoverController::class, 'index'])->name('discover.index');
    Route::get('/dashboard', [BlogController::class, 'index_dashboard'])->name('dashboard');
    Route::resource("blog", BlogController::class)/*->except(['edit'])*/;
    Route::get('blog/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit')->middleware(BlogOwnerMiddleware::class);
    Route::put('blog/{blog}', [BlogController::class, 'update'])->name('blog.update')->middleware(BlogOwnerMiddleware::class);
    Route::delete('blog/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy')->middleware(BlogOwnerMiddleware::class);
    Route::post('/blog/{blog}/report', [BlogController::class, 'report'])->name('blog.report');
});


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/blog/{blog}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::post('/comment/{comment}/report', [CommentController::class, 'report'])->name('comment.report');
    Route::post('/blog/{blog}/favorite', [FavoriteController::class, 'toggleFavorite'])->name('blog.favorite');
    Route::post('/blogs/{blog}/share', [BlogController::class, 'share'])->name('blog.share');
    Route::get('/profile/{user_id}', [AuthorController::class, 'index'])->name('author.index');

    Route::get('/search', [SearchController::class, 'index'])->name('search');

    Route::get('/page/about-us', [PageController::class, 'about'])->name('about');
    Route::get('/page/contact-us', [PageController::class, 'contact'])->name('contact');
    Route::get('/page/privacy', [PageController::class, 'privacy'])->name('privacy');
});

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

Route::post('/blogs/{blog}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::post('/blogs/{blog}/track-view-time', [BlogController::class, 'trackViewTime'])->name('blogs.track-view-time');

Route::get('/home', function () {
    return view('home');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


Route::get('/gemini', [GeminiController::class, 'index'])->name('gemini.index');
Route::post('/gemini/chat', [GeminiController::class, 'chat'])->name('gemini.chat');
Route::post('/notifications/{notification}/mark-as-read', function (Request $request, $notificationId) {
    $user = $request->user(); // Thay auth()->user()
    $user->notifications()->find($notificationId)->markAsRead();
    return back();
})->name('notifications.markAsRead');

require __DIR__ . '/auth.php';
