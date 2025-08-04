<?php
// 代码生成时间: 2025-08-05 05:31:19
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Contracts\Encryption\EncryptException;

class PasswordEncryptionTool {

    /**
     * Encrypt a password
     *
     * @param string $password The password to encrypt
     * @return string The encrypted password
     * @throws EncryptException
     */
    public function encryptPassword(string $password): string {
        if (empty($password)) {
            throw new \Exception('Password is required for encryption.');
        }

        try {
            return encrypt($password);
        } catch (EncryptException $e) {
            throw new \Exception('Encryption failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Decrypt a password
     *
     * @param string $encryptedPassword The encrypted password to decrypt
     * @return string The decrypted password
     * @throws EncryptException
     */
    public function decryptPassword(string $encryptedPassword): string {
        if (empty($encryptedPassword)) {
            throw new \Exception('Encrypted password is required for decryption.');
        }

        try {
            return decrypt($encryptedPassword);
        } catch (EncryptException $e) {
            throw new \Exception('Decryption failed: ' . $e->getMessage(), 0, $e);
        }
    }
}
