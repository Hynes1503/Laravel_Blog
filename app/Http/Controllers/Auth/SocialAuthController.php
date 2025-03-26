<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;
class SocialAuthController extends Controller
{
    // Chuyển hướng người dùng đến trang xác thực của Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lý dữ liệu từ Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Kiểm tra xem user đã tồn tại chưa
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Nếu chưa có, tạo user mới
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt('password'), // Đặt mật khẩu ngẫu nhiên (không dùng)
                ]);
            }

            // Đăng nhập user
            Auth::login($user);

            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Đăng nhập thất bại.');
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Xử lý callback từ Facebook
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            // Kiểm tra xem user đã tồn tại chưa
            $user = User::where('email', $facebookUser->getEmail())->first();

            if (!$user) {
                // Tạo tài khoản mới nếu chưa tồn tại
                $user = User::create([
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'password' => bcrypt(str()->random(12)), // Tạo mật khẩu ngẫu nhiên
                    'facebook_id' => $facebookUser->getId(),
                ]);
            }

            // Đăng nhập user
            Auth::login($user);

            return redirect('/dashboard')->with('success', 'Đăng nhập thành công!');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    private function postToFacebook($blog)
    {
        $pageId = config('services.facebook_post.page_id');
        $accessToken = config('services.facebook_post.access_token');

        $url = "https://graph.facebook.com/v20.0/{$pageId}/feed";
        $message = "Bài viết mới: {$blog->title}\n{$blog->description}\nXem chi tiết: " . route('blog.show', $blog->id);

        $response = Http::post($url, [
            'message' => $message,
            'access_token' => $accessToken,
        ]);

        if ($response->successful()) {
            // Lưu ID bài đăng trên Facebook vào database (nếu cần lấy thống kê sau này)
            $blog->facebook_post_id = $response->json()['id'];
            $blog->save();
        } else {
            Log::error('Failed to post to Facebook: ' . $response->body());
        }
    }
}
