<?php

namespace Core;

use App\Auth;

/**
 * Base controller
 */
abstract class Controller
{

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name Method name
     * @param array  $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     * 
     * @return void
     */
    protected function after()
    {
    }

    /**
     * Redirect to url
     * 
     * @param string $url Url for redirect
     * 
     * @return void
     */
    public function redirect($url)
    {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url, true, 303);
        exit();
    }

    /**
     * Require login
     * 
     * @return void
     */
    public function requireLogin()
    {
        if (!Auth::getUser()) {
            $this->redirect('/login');
        }
    }

    /**
     * Require login
     * 
     * @return void
     */
    public function requireLogout()
    {
        if (Auth::getUser()) {
            $this->redirect('/');
        }
    }
}
