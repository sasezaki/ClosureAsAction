<?php
namespace ClosureAsAction;

use Zend\Mvc\DispatchListener as BaseDispatchListener;

class Module
{
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'ControllerLoader' => 'ClosureAsAction\Mvc\Service\ControllerLoaderFactory',
            ],    
            'invokables' => [
                'DispatchListener' => 'ClosureAsAction\Mvc\DispatchListener'
            ]
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
