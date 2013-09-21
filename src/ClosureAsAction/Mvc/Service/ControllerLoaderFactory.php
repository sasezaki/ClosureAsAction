<?php
namespace ClosureAsAction\Mvc\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ClosureAsAction\Mvc\Controller\ControllerManager;

class ControllerLoaderFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controllerLoader = new ControllerManager();
        $controllerLoader->setServiceLocator($serviceLocator);
        $controllerLoader->addPeeringServiceManager($serviceLocator);

        $config = $serviceLocator->get('Config');

        if (isset($config['di']) && isset($config['di']['allowed_controllers']) && $serviceLocator->has('Di')) {
            $controllerLoader->addAbstractFactory($serviceLocator->get('DiStrictAbstractServiceFactory'));
        }

        return $controllerLoader;
    }
}
