<?php
// 代码生成时间: 2025-08-26 07:47:57
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// UserPermissionManagement 类负责处理用户权限管理相关的逻辑
class UserPermissionManagement {
    // 数据库管理器
    protected $db;

    // 构造函数
    public function __construct(DatabaseManager $db) {
        $this->db = $db;
    }

    // 获取用户权限
    public function getUserPermissions($userId) {
        try {
            // 从数据库中查询用户权限
            $query = DB::table('permissions')
                ->where('user_id', $userId)
                ->get();

            // 检查查询结果是否为空
            if ($query->isEmpty()) {
                // 记录错误日志
                Log::error('No permissions found for user: ' . $userId);
                return [];
            } else {
                return $query->pluck('permission_name')->toArray();
            }
        } catch (\Exception $e) {
            // 记录异常日志
            Log::error('Error fetching user permissions: ' . $e->getMessage());
            throw $e;
        }
    }

    // 添加用户权限
    public function addUserPermission($userId, $permissionName) {
        try {
            // 向数据库中插入新的权限记录
            DB::table('permissions')
                ->insert([
                    'user_id' => $userId,
                    'permission_name' => $permissionName,
                ]);
        } catch (\Exception $e) {
            // 记录异常日志
            Log::error('Error adding user permission: ' . $e->getMessage());
            throw $e;
        }
    }

    // 删除用户权限
    public function removeUserPermission($userId, $permissionName) {
        try {
            // 从数据库中删除权限记录
            DB::table('permissions')
                ->where('user_id', $userId)
                ->where('permission_name', $permissionName)
                ->delete();
        } catch (\Exception $e) {
            // 记录异常日志
            Log::error('Error removing user permission: ' . $e->getMessage());
            throw $e;
        }
    }
}
