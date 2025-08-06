<?php
// 代码生成时间: 2025-08-06 20:26:35
// user_authentication.php
// 这个文件包含了用户身份认证的功能。

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserAuthenticationController extends Controller
{
    // 用户登录
    public function login(Request $request)
    {
        // 验证请求数据
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            // 如果验证失败，返回错误信息
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 尝试认证用户
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // 如果认证成功，返回成功信息和用户信息
            $user = Auth::user();
            return response()->json(['message' => 'Logged in successfully', 'user' => $user], 200);
        }

        // 如果认证失败，返回错误信息
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    // 用户注册
    public function register(Request $request)
    {
        // 验证请求数据
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            // 如果验证失败，返回错误信息
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 创建新用户
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // 用户创建成功后，返回成功信息和用户信息
        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }
}
