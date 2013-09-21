<?php

return array(
    'router' => array(
        'routes' => array(
            'closureasaction' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/closureasaction',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ClosureAsAction\Controller',
                        'controller'    => 'Index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'services' => array(
            'ClosureAsAction\Controller\Index' => function ($params) {
                return new Zend\View\Model\ViewModel();
            },
            'ClosureAsAction\Controller\Foo' => function ($params) {
                return [
                    'bar' => 'b<a>z',
                    'event' => var_export($this->event->getName(), true)
                ];
            }
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'index' => __DIR__ . '/../view/closure-as-action/foo.phtml',
            'foo' => __DIR__ . '/../view/closure-as-action/foo.phtml',
        ),
    ),
);
