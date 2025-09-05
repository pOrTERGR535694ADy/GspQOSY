<?php
// 代码生成时间: 2025-09-06 06:18:08
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

// 控制器类用于处理用户登录请求
class LoginController extends Controller
{
    // 用户登录方法
    public function login(Request \$request)
    {
        // 验证输入数据
        \$validator = Validator::make(\$request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 检查验证是否失败
        if (\$validator->fails()) {
            return response()->json(['errors' => \$validator->errors()], 422);
        }

        // 尝试使用提供的用户信息登录
        \$credentials = \$request->only('email', 'password');

        if (Auth::attempt(\$credentials)) {
            // 如果登录成功，生成令牌并返回
            \$user = Auth::user();
            \$token = \$user->createToken('myapptoken')->plainTextToken;
            return response()->json(['user' => \$user, 'token' => \$token], 200);
        } else {
            // 如果登录失败，返回错误信息
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
