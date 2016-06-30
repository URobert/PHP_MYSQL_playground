<?php

namespace TestProject\Controller;

interface ControllerInterface
{
    public function __construct($app);
    public function action();
}
