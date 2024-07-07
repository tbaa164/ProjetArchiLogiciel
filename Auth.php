<?php

class Auth {
    public static function isLoggedIn() {
        return isset($_SESSION['jwt']) && !empty($_SESSION['jwt']);
    }

    public static function isAdmin() {
        return self::isLoggedIn() && self::getUserRole() === 'admin';
    }

    public static function getUserRole() {
        if (self::isLoggedIn()) {
            $jwtManager = new JwtManager('b8e1f59c6e774a0c91f9d4b8a6d7e4a29cf9d4c4e8e7c6b1a8d9f9d2f8c9e2b4');
            $decoded = $jwtManager->decodeToken($_SESSION['jwt']);
            return $decoded['role'] ?? null;
        }
        return null;
    }

    public static function isEditor() {
        return self::isLoggedIn() && (self::getUserRole() === 'editor' || self::isAdmin());
    }

    public static function login($user) {
        $_SESSION['user'] = $user;
    }

    public static function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['jwt']);
    }

    public static function getUser() {
        return $_SESSION['user'] ?? null;
    }
}
?>
