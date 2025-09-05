<?php
// 代码生成时间: 2025-09-05 12:07:10
use Illuminate\Support\Facades\Log;
use App\Models\AuditLog;
use Exception;

/**
 * Service class for handling security audit logs.
 */
class AuditLogService {

    /**
     * Logs a security audit entry.
     *
     * @param array $data Data to be logged.
     * @return bool
     * @throws Exception If the logging fails.
     */
    public function logSecurityAudit(array $data): bool
    {
        try {
            // Validate the data before logging
            $this->validateData($data);

            // Create a new audit log entry
            $auditLog = new AuditLog();
            $auditLog->user_id = $data['user_id'] ?? null;
            $auditLog->action = $data['action'] ?? null;
            $auditLog->details = json_encode($data);

            // Save the audit log to the database
            if (!$auditLog->save()) {
                throw new Exception('Failed to save audit log entry.');
            }

            // Log the audit entry using Laravel's logging mechanism
            Log::info('Security audit log entry created', $data);

            return true;
        } catch (Exception $e) {
            // Log the exception
            Log::error('Error logging security audit: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Validates the data before logging.
     *
     * @param array $data Data to be validated.
     * @throws Exception If validation fails.
     */
    private function validateData(array $data): void
    {
        // Ensure required fields are present
        if (empty($data['user_id']) || empty($data['action'])) {
            throw new Exception('Missing required fields for audit log entry.');
        }
    }
}
