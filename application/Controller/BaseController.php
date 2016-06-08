<?php

namespace TestProject\Controller;


class BaseController {

    private $route_entry;
    
    final public function render($arguments = array()) {        
        ob_start();
        extract($arguments);
        require sprintf(
            '../application/Controller/Location/View/%s/%s.php',
            array_pop(explode("\\", get_class($this))),
            $this->route_entry['function']
        );
        return ob_get_clean();
        
        //ob_start();
        //require('layout');
        //$layout = ob_get_clean();
        //return str_replace('MAIN_CONTENT', $content, $layout);
        //
    }
    
    
    final public function setRouteInformation(array $route_entry) {
        $this->route_entry = $route_entry;
    }
}