<?php
// 代码生成时间: 2025-08-20 14:29:18
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * FormValidator class handles form data validation.
 *
 * This class is designed to validate form data using Laravel's built-in validation system.
 * It provides a clear structure and includes error handling and documentation.
 *
 * @package App\Http\Controllers
 */
class FormValidator
{
    /**
     * Validates the form data and returns the validated data or throws an exception.
     *
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    public function validateForm(Request $request)
    {
        // Define the validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'age' => 'required|integer|min:18'
        ];

        // Create a Validator instance and check the rules
        $validator = Validator::make($request->all(), $rules);

        // If the validation fails, throw a ValidationException
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Return the validated data
        return $validator->validated();
    }
}
