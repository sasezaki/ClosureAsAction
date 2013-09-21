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
                return [];
            }
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        
        'template_map' => array(
            'foo' => __DIR__ . '/../view/closure-as-action/foo.phtml',
        ),
    ),
);
