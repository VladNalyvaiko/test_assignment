<?php

namespace App\Controllers;

use App\Middlewares\Auth as AuthMiddleware;
use App\Auth;

class Logout extends AuthMiddleware
{
    /**
     * Logout user
     *
     * @return void
     */
    public function destroy()
    {
        Auth::logout();
        $this->redirect('/');
    }
}
