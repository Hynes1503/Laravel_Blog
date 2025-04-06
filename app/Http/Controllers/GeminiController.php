<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller
{
    public function index()
    {
        return view('gemini');
    }

    public function chat(Request $request)
    {
        $message = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            Log::error('API Key is missing in .env');
            return response()->json(['reply' => 'Lỗi: API Key không được cấu hình'], 500);
        }

        $client = new Client();
        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";
            Log::info('Sending request to: ' . $url);

            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $message]
                            ]
                        ]
                    ]
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            Log::info('Gemini API Response: ', $data);

            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                $reply = $data['candidates'][0]['content']['parts'][0]['text'];
            } else {
                $reply = 'Không tìm thấy nội dung phản hồi từ API';
                Log::warning('Unexpected API response structure: ', $data);
            }

            return response()->json(['reply' => $reply]);
        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            return response()->json(['reply' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }
}