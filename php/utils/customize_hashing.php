<?php
    // Method to hash a password
    function hashPassword(string $password): string {
        // Hash the password using bcrypt (default algorithm in password_hash)
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // Method to verify the password against the stored hash
    function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
    function generatePassword($length = 12) {
        // Define the characters allowed in the password
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
        $password = '';
        // Generate a random password
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $password;
    }
?>