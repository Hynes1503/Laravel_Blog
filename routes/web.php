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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\BlogOwnerMiddleware;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\CategoryController;
use App\Models\Category;

Route::middleware(['auth', 'verified', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });
    Route::resource('categories', AdminCategoryController::class);
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/statiscal', [StatisticalController::class, 'index'])->name('admin.statiscal.index');
    Route::resource('blog', AdminBlogController::class)->names('admin.blog');
    Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('/user/{user_id}', [UserController::class, 'index_author'])->name('admin.user.show');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/category/{id}', [CategoryController::class, 'index'])->name('user.category.index');
    Route::get('/discover', [DiscoverController::class, 'index'])->name('discover.index');
    Route::get('/dashboard', [BlogController::class, 'index_dashboard'])->name('dashboard');
    Route::resource("blog", BlogController::class)/*->except(['edit'])*/;
    Route::get('blog/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit')->middleware(BlogOwnerMiddleware::class);
    Route::put('blog/{blog}', [BlogController::class, 'update'])->name('blog.update')->middleware(BlogOwnerMiddleware::class);
    Route::delete('blog/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy')->middleware(BlogOwnerMiddleware::class);
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
    Route::post('/blog/{blog}/favorite', [FavoriteController::class, 'toggleFavorite'])->name('blog.favorite');
    Route::post('/blog/{blog}/share', [SocialAuthController::class, 'shareOnFacebook'])->name('blog.share');

    Route::get('/profile/{user_id}', [AuthorController::class, 'index'])->name('author.index');

    Route::get('/search', [SearchController::class, 'index'])->name('search');
    // Route::get('/search', [SearchController::class, 'admin_index'])->name('admin.search');

    Route::view('/about', 'footer.about')->name('about');
    Route::view('/contact', 'footer.contact')->name('contact');
    Route::view('/privacy', 'footer.privacy')->name('privacy');
});

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

Route::post('/blogs/{blog}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

Route::get('/home', function () {
    return view('home');
});

require __DIR__ . '/auth.php';
