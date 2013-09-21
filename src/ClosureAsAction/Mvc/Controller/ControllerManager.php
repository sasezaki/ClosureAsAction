<?php
namespace ClosureAsAction\Mvc\Controller;

use Closure;
use Zend\Mvc\Controller\ControllerManager as BaseControllerManager;

class ControllerManager extends BaseControllerManager
{
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof Closure) {
            return;
        }

        return parent::validatePlugin($plugin);
    }
}
