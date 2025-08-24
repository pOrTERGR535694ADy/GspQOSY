<?php
// 代码生成时间: 2025-08-25 06:59:37
// NetworkConnectionChecker.php

use Illuminate\Support\Facades\{Http};
use Illuminate\Support\Facades\Log;
use Exception;

class NetworkConnectionChecker {
    // 检查网络连接状态
    public function checkConnection($url) {
        try {
            // 发起HTTP请求
            $response = Http::timeout(10)->get($url);
            
            // 检查HTTP响应状态码
            if ($response->successful()) {
                Log::info("Connection to {$url} is successful.");
                return true;
            } else {
                Log::warning("Failed to connect to {$url}. Status code: {$response->status()}");
                return false;
            }
        } catch (Exception $e) {
            // 记录异常信息
            Log::error("Error checking connection to {$url}: {$e->getMessage()}");
            return false;
        }
    }
}
