<?php

namespace App\Controllers;

use App\Auth;
use App\Repositories\UserRepository;
use Core\View;
use App\Middlewares\Web;

class Login extends Web
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function index()
    {
        View::renderTemplate('Login/index.html');
    }

    /**
     * Login user
     *
     * @return void
     */
    public function create()
    {
        $user = UserRepository::authenticate($_POST['email'], $_POST['password']);

        if ($user) {
            Auth::login($user);
            $this->redirect(Auth::getReturnToPage());
        } else {
            View::renderTemplate(
                'Login/index.html', [
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'error' => 'You\'re login unsuccessfully, please try again'
                ]
            );
        }
    }
}