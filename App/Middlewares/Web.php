<?php

namespace App\Middlewares;

abstract class Web extends \Core\Controller
{
    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
        $this->requireLogout();
    }
}
