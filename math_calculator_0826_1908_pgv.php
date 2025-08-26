<?php
// 代码生成时间: 2025-08-26 19:08:27
namespace App\Services;

use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class MathCalculator {

    /**
     * Adds two numbers.
     *
     * @param float $number1
     * @param float $number2
     * @return float
     */
    public function add(float $number1, float $number2): float {
        return $number1 + $number2;
    }

    /**
     * Subtracts the second number from the first.
     *
     * @param float $number1
     * @param float $number2
     * @return float
     */
    public function subtract(float $number1, float $number2): float {
        return $number1 - $number2;
    }

    /**
     * Multiplies two numbers.
     *
     * @param float $number1
     * @param float $number2
     * @return float
     */
    public function multiply(float $number1, float $number2): float {
        return $number1 * $number2;
    }

    /**
     * Divides the first number by the second number.
     *
     * @param float $number1
     * @param float $number2
     * @return float
     * @throws InvalidArgumentException if the divisor is zero.
     */
    public function divide(float $number1, float $number2): float {
        if ($number2 === 0.0) {
            throw new InvalidArgumentException('Cannot divide by zero.');
        }
        return $number1 / $number2;
    }

    /**
     * Validates input numbers.
     *
     * @param array $numbers
     * @return bool
     */
    protected function validateNumbers(array $numbers): bool {
        $validator = Validator::make($numbers, [
            '0' => 'required|numeric',
            '1' => 'required|numeric',
        ]);

        return $validator->passes();
    }
}
