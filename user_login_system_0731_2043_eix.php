<?php
// 代码生成时间: 2025-07-31 20:43:50
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// UserLoginController 控制器负责处理用户登录逻辑
class UserLoginController extends Controller
{
    // 显示登录表单
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 处理登录请求
    public function login(Request $request)
    {
        // 验证请求数据
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 尝试使用提供的凭据认证用户
        if (Auth::attempt($credentials)) {
            // 认证成功后重定向到首页
            return redirect()->intended('dashboard');
        }

        // 认证失败，返回登录表单并附加错误消息
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    // 用户登出
    public function logout()
    {
        Auth::logout();

        // 登出后重定向到登录表单
        return redirect('login');
    }
}
