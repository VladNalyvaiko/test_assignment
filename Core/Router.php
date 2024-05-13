<?php

namespace Core;

class Router
{
    /**
     * Add get rout
     * 
     * @param string $route
     * @param string $methoud
     *
     * @return void
     */
    public static function get(string $route, string $methoud)
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') !== 0) {
            return;
        }

        self::on($route, $methoud);
    }

    /**
     * Add post rout
     * 
     * @param string $route
     * @param string $methoud
     *
     * @return void
     */
    public static function post(string $route, string $methoud)
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') !== 0) {
            return;
        }

        self::on($route, $methoud);
    }

    /**
     * Add delete rout
     * 
     * @param string $route
     * @param string $methoud
     *
     * @return void
     */
    public static function delete(string $route, string $methoud)
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE') !== 0) {
            return;
        }

        self::on($route, $methoud);
    }

    /**
     * @param string $route
     * @param string $methoud
     *
     * @return void
     */
    public static function on(string $regex, string $methoud)
    {
        $params = $_SERVER['REQUEST_URI'];
        $params = (stripos($params, "/") !== 0) ? "/" . $params : $params;
        $regex = str_replace('/', '\/', $regex);
        $is_match = preg_match(
            '/^' . ($regex) . '$/', $params, $matches, PREG_OFFSET_CAPTURE
        );

        if ($is_match) {
            // first value is normally the route, lets remove it
            array_shift($matches);
            // Get the matches as parameters
            $params = array_map(function ($param) {
                return $param[0];
            }, $matches);

            $data = explode('@', $methoud);
            $controller = 'App\Controllers\\' . $data[0];
            $action = $data[1];

            $controller_object = new $controller();
            $controller_object->$action(new Request($params), new Response());
        }
    }
}