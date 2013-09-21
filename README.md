ClosureAsAction - ZF2 Module
============================

experimental Module.

aims to just do below thing at module.config.php

```
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
```
