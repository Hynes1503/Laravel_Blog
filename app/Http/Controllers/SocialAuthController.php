<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
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
}
