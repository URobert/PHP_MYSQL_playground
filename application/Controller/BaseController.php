<?php

namespace TestProject\Controller;


class BaseController {

    private $template;
    private $route_entry;
    
    public function __construct($app) {
        $this->template = $app['template'];
    }
    
    final public function render($arguments) {
        $template = $this->template;
        
        return $template(
            $this->route_entry['function'],
            array_pop(explode("\\", get_class($this))),
            $arguments
        );
    }
    
    final public function setRouteInformation(array $route_entry) {
        $this->route_entry = $route_entry;
    }
}