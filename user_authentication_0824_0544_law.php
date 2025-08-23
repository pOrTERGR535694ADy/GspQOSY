<?php
// 代码生成时间: 2025-08-24 05:44:11
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
# 添加错误处理
use App\Models\User;

// UserController is responsible for handling user authentication.
class UserController extends Controller
{
    // Login method to authenticate users.
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
# 改进用户体验
            'password' => 'required',
# NOTE: 重要实现细节
        ]);

        // Attempt to authenticate the user.
        if (Auth::attempt($credentials)) {
            // Authentication passed, generate a token.
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;

            // Return the token and user details.
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
# 增强安全性
                'user' => $user,
# 添加错误处理
            ], 200);
# TODO: 优化性能
        } else {
            // Authentication failed, return an error.
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    // Register method to create a new user.
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        // Create a new user with the validated data.
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        // Generate a token for the new user.
        $token = $user->createToken('authToken')->accessToken;

        // Return the token and user details.
        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user,
# 添加错误处理
        ], 201);
    }

    // Logout method to invalidate a token.
    public function logout()
    {
        // Invalidate the token on logout.
# NOTE: 重要实现细节
        Auth::user()->tokens()->delete();

        // Return a success message.
# 改进用户体验
        return response()->json(['message' => 'You have been logged out'], 200);
    }
}
# TODO: 优化性能
