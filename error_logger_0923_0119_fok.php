<?php
// 代码生成时间: 2025-09-23 01:19:25
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * ErrorLogger class responsible for collecting and storing error logs.
 */
class ErrorLogger {

    /**
     * Path to store the error logs.
     */
    private string $logPath;

    /**
     * ErrorLogger constructor.
     *
     * @param string $logPath
     */
    public function __construct(string $logPath = 'storage/logs/error.log') {
        $this->logPath = $logPath;
    }

    /**
     * Logs an error message to the log file with proper exception handling.
     *
     * @param Throwable $exception
     * @return void
     */
    public function logError(Throwable $exception): void {
        try {
            // Ensure the log directory exists
            if (!Storage::exists("logs")) {
                Storage::makeDirectory("logs");
            }

            // Format the error message
            $errorMessage = sprintf(
                "[%s] %s: %s in %s line %d\\
",
                date('Y-m-d H:i:s'),
                get_class($exception),
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine()
            );

            // Append the error message to the log file
            Storage::append($this->logPath, $errorMessage);

            // Also log the error using Laravel's built-in logging
            Log::error($errorMessage);
        } catch (Throwable $exception) {
            // In case of failure, attempt to log the error using PHP's error_log function
            error_log($exception->getMessage());
        }
    }
}
