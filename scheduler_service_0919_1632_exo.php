<?php
// 代码生成时间: 2025-09-19 16:32:56
namespace App\Services;

use Illuminate\Support\Facades\Schedule;
use Illuminate\Console\Scheduling\Schedule as ScheduleClass;
use Illuminate\Support\Facades\Log;

class SchedulerService
{
    /**
     * 注册任务调度器
     *
     * @param ScheduleClass $schedule
     */
    public function scheduleTasks(ScheduleClass $schedule)
    {
        // 每小时执行一次示例任务
        $schedule->call(function () {
            // 在这里添加任务逻辑
            Log::info('Scheduled task executed at ' . date('Y-m-d H:i:s'));
        })->hourly();

        // 你可以添加更多的任务调度
    }

    /**
     * 启动定时任务
     *
     * @return void
     */
    public function start()
    {
        try {
            $this->scheduleTasks(app(ScheduleClass::class));
        } catch (\Exception $e) {
            // 错误处理
            Log::error('Error starting scheduler: ' . $e->getMessage());
            throw $e;
        }
    }
}
