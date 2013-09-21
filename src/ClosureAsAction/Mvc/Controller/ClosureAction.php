<?php
namespace ClosureAsAction\Mvc\Controller;

use Closure;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ClosureAction extends AbstractController
{
    protected $closure = null;

    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    public function onDispatch(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $application = $e->getApplication();
        $request = $e->getRequest();
        $response = $application->getResponse();

        $closure = $this->closure;
        // if php > 5.4
        if (PHP_VERSION_ID > 50400) {
            $closure = $closure->bindTo($this);
        }
    
        $result = $closure(
            $routeMatch->getParams(), $request, $response
        );

        if (is_array($result)) {
            $result = new ViewModel($result);
        }

        $params = $routeMatch->getParams();

        if ($result instanceof ViewModel) {
            $result->setTemplate($params['__CONTROLLER__']);
        }

        $e->setResult($result);
        return $result;
    }
}
