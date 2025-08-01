<?php
// 代码生成时间: 2025-08-02 02:00:09
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UrlValidatorController extends Controller
{
    // 验证URL链接有效性的函数
    public function validateUrl(Request $request)
    {
        // 获取请求中的URL
        $url = $request->input('url');

        // 检查URL是否为空
        if (empty($url)) {
            return response()->json(['error' => 'URL cannot be empty.'], 400);
        }

        // 使用GuzzleHttp来发送HEAD请求，检查URL是否存在
        try {
            $response = Http::head($url);
        } catch (Exception $e) {
            // 如果请求失败，返回错误信息
            return response()->json(['error' => 'URL is invalid or not reachable.'], 400);
        }

        // 检查HTTP响应状态码是否表示成功
        if ($response->successful()) {
            // 返回成功的响应
            return response()->json(['message' => 'URL is valid.'], 200);
        } else {
            // 如果响应状态码不是200系列，返回错误信息
            return response()->json(['error' => 'URL is invalid or not reachable.'], 400);
        }
    }
}
