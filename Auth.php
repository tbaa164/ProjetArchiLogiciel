<?php

class Auth {
    public static function isLoggedIn() {
        return isset($_SESSION['user']);
    }

    public static function isAdmin() {
        return self::isLoggedIn() && $_SESSION['user']['role'] === 'admin';
    }

    public static function getUserRole() {
        return $_SESSION['user']['role'] ?? null;
    }

    public static function isEditor() {
        return self::isLoggedIn() && ($_SESSION['user']['role'] === 'editor' || $_SESSION['user']['role'] === 'admin');
    }

    public static function login($user) {
        $_SESSION['user'] = $user;
    }

    public static function logout() {
        unset($_SESSION['user']);
    }

    public static function getUser() {
        return $_SESSION['user'] ?? null;
    }
}
?>
