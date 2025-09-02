<?php
// 代码生成时间: 2025-09-03 06:43:21
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FormValidator {
    /**
     * Validate the incoming form data.
     *
     * @param array $data The form data to be validated.
     * @return void
     * @throws ValidationException
     */
    public function validate(array $data) {
        // Define the validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'age' => 'required|integer|between:18,100',
        ];

        // Define custom error messages for the validation
        $messages = [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
            'age.required' => 'Age is required.',
        ];

        // Validate the data
        $validator = Validator::make($data, $rules, $messages);

        // Check if the validation fails
        if ($validator->fails()) {
            // Throw a ValidationException with the error messages
            throw new ValidationException($validator);
        }
    }

    /**
     * Handle the form submission.
     *
     * @param array $data The form data.
     * @return void
     */
    public function handle(array $data) {
        try {
            // Validate the form data
            $this->validate($data);

            // If validation passes, proceed with the form processing
            // This could involve saving to a database, sending an email, etc.
            // For this example, we'll just return a success message
            return response()->json(['message' => 'Form submitted successfully.']);

        } catch (ValidationException $e) {
            // If validation fails, return the error messages
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
