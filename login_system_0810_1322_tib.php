<?php
// 代码生成时间: 2025-08-10 13:22:44
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

// LoginController 负责处理用户登录验证
class LoginController extends Controller
{
    // 显示登录表单
    public function showLoginForm()
    {
        return view('login');
    }

    // 处理登录请求
    public function login(Request $request)
    {
        // 验证请求数据
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 尝试登录
        if (Auth::attempt($credentials)) {
            // 登录成功，重定向到首页
            return redirect()->intended('/');
        }

        // 登录失败，返回登录表单并带有错误信息
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->withInput($request->only('email'));
    }

    // 用户登出
    public function logout()
    {
        Auth::logout();

        // 登出后重定向回登录页面
        return redirect('/login');
    }
}
