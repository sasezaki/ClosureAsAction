<?php
namespace ClosureAsAction\Mvc;

use Closure;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\DispatchListener as BaseDispatchListener;
use Zend\Mvc\InjectApplicationEventInterface;

use ClosureAsAction\Mvc\Controller\ClosureAction;

class DispatchListener extends BaseDispatchListener
{
    /**
     * Listen to the "dispatch" event
     *
     * @param  MvcEvent $e
     * @return mixed
     */
    public function onDispatch(MvcEvent $e)
    {
        $routeMatch       = $e->getRouteMatch();
        $controllerName   = $routeMatch->getParam('controller', 'not-found');
        $application      = $e->getApplication();
        $events           = $application->getEventManager();
        $controllerLoader = $application->getServiceManager()->get('ControllerLoader');

        if (!$controllerLoader->has($controllerName)) {
            $return = $this->marshallControllerNotFoundEvent($application::ERROR_CONTROLLER_NOT_FOUND, $controllerName, $e, $application);
            return $this->complete($return, $e);
        }

        try {
            $controller = $controllerLoader->get($controllerName);
        } catch (InvalidControllerException $exception) {
            $return = $this->marshallControllerNotFoundEvent($application::ERROR_CONTROLLER_INVALID, $controllerName, $e, $application, $exception);
            return $this->complete($return, $e);
        } catch (\Exception $exception) {
            $return = $this->marshallBadControllerEvent($controllerName, $e, $application, $exception);
            return $this->complete($return, $e);
        }

        $request  = $e->getRequest();
        $response = $application->getResponse();

        if ($controller instanceof Closure) {
            $controller = new ClosureAction($controller);
        }

        if ($controller instanceof InjectApplicationEventInterface) {
            $controller->setEvent($e);
        }

        try {
            $return = $controller->dispatch($request, $response);
        } catch (\Exception $ex) {
            $e->setError($application::ERROR_EXCEPTION)
                  ->setController($controllerName)
                  ->setControllerClass(get_class($controller))
                  ->setParam('exception', $ex);
            $results = $events->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $e);
            $return = $results->last();
            if (! $return) {
                $return = $e->getResult();
            }
        }

        return $this->complete($return, $e);
    }

}

