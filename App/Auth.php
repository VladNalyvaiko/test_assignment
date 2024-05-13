<?php

namespace App;

use App\Repositories\UserRepository;

class Auth
{
    public static function login($user)
    {
        // Store the user ID in the session
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
    }

    public static function logout()
    {
        // Unset all the session variables
        $_SESSION = [];
        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        // Finally, destroy the session
        session_destroy();
    }

    public static function getReturnToPage()
    {
        return $_SESSION['return_to'] ?? '/';
    }

    public static function getUser()
    {
        if (isset($_SESSION['user_id'])) {
            return UserRepository::getUser($_SESSION['user_id']);
        }
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
}