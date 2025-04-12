<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Purchase;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function momoPayment(Blog $blog)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create"; // URL MoMo sandbox
        $partnerCode = "YOUR_PARTNER_CODE";
        $accessKey = "YOUR_ACCESS_KEY";
        $secretKey = "YOUR_SECRET_KEY";
        $orderId = time() . "_" . $blog->id;
        $orderInfo = "Thanh toán bài viết: " . $blog->title;
        $amount = "10000"; 
        $redirectUrl = route('payment.momo.callback');
        $ipnUrl = route('payment.momo.callback');
        $requestId = time() . "";

        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=&ipnUrl=" . $ipnUrl .
            "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode .
            "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=captureWallet";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Blog App",
            'storeId' => "BlogStore",
            'requestType' => "captureWallet",
            'ipnUrl' => $ipnUrl,
            'redirectUrl' => $redirectUrl,
            'orderId' => $orderId,
            'amount' => $amount,
            'lang' => 'vi',
            'orderInfo' => $orderInfo,
            'requestId' => $requestId,
            'extraData' => base64_encode(json_encode(['blog_id' => $blog->id])),
            'signature' => $signature,
        ];

        $response = Http::post($endpoint, $data);
        $result = $response->json();

        if ($result['resultCode'] == 0) {

            session()->put('pending_payment_order_id', $orderId);
            return redirect($result['payUrl']);
        }

        return back()->with('error', 'Không thể tạo thanh toán MoMo.');
    }

    public function momoCallback(Request $request)
    {
        $data = $request->all();
        if ($data['resultCode'] == 0) {
            $extraData = json_decode(base64_decode($data['extraData']), true);
            $blogId = $extraData['blog_id'];
            $pendingOrderId = session('pending_payment_order_id');


            if ($pendingOrderId === $data['orderId']) {

                session()->put('purchased_blogs.' . $blogId, true);
                session()->forget('pending_payment_order_id');
                return redirect()->route('blog.show', $blogId)->with('success', 'Thanh toán thành công!');
            }
        }
        return redirect()->route('dashboard')->with('error', 'Thanh toán thất bại.');
    }
}
