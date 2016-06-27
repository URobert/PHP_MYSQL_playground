<?php

namespace TestProject\Controller;

class BaseController
{
    private $route_entry;

    final public function render($arguments = array())
    {
        $isLoggedIn = isset($_SESSION['userId']) && $_SESSION['userId'] >= 1;
        ob_start();
        extract($arguments);
        require sprintf(
            '../application/Controller/Location/View/%s/%s.php',
            array_pop(explode('\\', get_class($this))),
            $this->route_entry['function']
        );
        $content = ob_get_clean();

        ob_start();
        require '../application/layout.php';

        return ob_get_clean();
        //
    }

    final public function setRouteInformation(array $route_entry)
    {
        $this->route_entry = $route_entry;
    }
}
