<?php
// 代码生成时间: 2025-09-17 21:06:32
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

// ApiResponseFormatter 是一个简单的工具类，用于格式化Laravel API响应
class ApiResponseFormatter {
    // 格式化成功的响应
    public static function success($data, $message = 'Operation successful', $status = FoundationResponse::HTTP_OK): Response {
        return response()->json([
            'success' => true,
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    // 格式化失败的响应
    public static function error($message = 'Operation failed', $status = FoundationResponse::HTTP_BAD_REQUEST, $data = null): Response {
        return response()->json([
            'success' => false,
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}

// 使用示例
// 确保在Laravel控制器中使用这个工具类进行API响应格式化
// \u003c?php
// namespace App\Http\Controllers;
//
// use Illuminate\Http\Request;
// use ApiResponseFormatter;
//
// class ExampleController extends Controller {
//     public function example(Request $request) {
//         try {
//             // 业务逻辑处理
//             $data = [];
//             // ...
//             // 返回成功的响应
//             return ApiResponseFormatter::success($data);
//         } catch (\Exception $e) {
//             // 返回失败的响应
//             return ApiResponseFormatter::error($e->getMessage(), FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
//         }
//     }
// }
