<?php
// 代码生成时间: 2025-08-12 18:05:29
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\QueryException;
use Exception;

class ApiResponseFormatter
{
    /**
     * Format API response with success status.
     *
     * @param mixed \$data
     * @param string \$message
     * @param int \$code
     * @return \Illuminate\Http\JsonResponse
     */
    public function success(\$data = null, \$message = 'Success', \$code = 200)
    {
        return Response::json([
            'status' => 'success',
            'data' => \$data,
            'message' => \$message,
        ], \$code);
    }

    /**
     * Format API response with error status.
     *
     * @param string \$message
     * @param int \$code
     * @param array \$errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(\$message = 'Error', \$code = 500, \$errors = [])
    {
        return Response::json([
            'status' => 'error',
            'message' => \$message,
            'errors' => \$errors,
        ], \$code);
    }

    /**
     * Format API response for validation errors.
     *
     * @param \Illuminate\Http\Request \$request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validationError(Request \$request)
    {
        \$errors = \$request->validator->errors()->getMessages();
        \$message = 'Validation errors occurred.';

        return \$this->error(\$message, 422, \$errors);
    }

    /**
     * Handle query exceptions and return a formatted error response.
     *
     * @param QueryException \$queryException
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleQueryException(QueryException \$queryException)
    {
        \$message = \$queryException->getMessage();
        \$code = 500; // Default internal server error code

        // You can customize the error code based on the exception type

        return \$this->error(\$message, \$code);
    }

    /**
     * Handle generic exceptions and return a formatted error response.
     *
     * @param Exception \$exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleException(Exception \$exception)
    {
        \$message = \$exception->getMessage();
        \$code = 500; // Default internal server error code

        return \$this->error(\$message, \$code);
    }
}
