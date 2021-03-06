<?php

return [
    'services' => [
        'config' => include __DIR__ . '/config.php',
    ],
    'aliases' => [
        // Expressive 2.0:
        'Zend\Expressive\Delegate\DefaultDelegate' => 'Zend\Expressive\Delegate\NotFoundDelegate',
    ],
    'invokables' => [
        'Zend\Expressive\Router\RouterInterface'     => 'Zend\Expressive\Router\AuraRouter',
        'Zend\Expressive\Template\TemplateRendererInterface' => 'Zend\Expressive\Twig\TwigRenderer'
    ],
    'factories' => [
        'Zend\Expressive\Application'       => 'Zend\Expressive\Container\ApplicationFactory',
        'Zend\Expressive\Whoops'            => 'Zend\Expressive\Container\WhoopsFactory',
        'Zend\Expressive\WhoopsPageHandler' => 'Zend\Expressive\Container\WhoopsPageHandlerFactory',

        // Expressive 2.0:
        'Zend\Expressive\Middleware\ErrorHandler'    => 'Zend\Expressive\Container\ErrorHandlerFactory',
        'Zend\Expressive\Delegate\NotFoundDelegate'  => 'Zend\Expressive\Container\NotFoundDelegateFactory',
        'Zend\Expressive\Middleware\NotFoundHandler' => 'Zend\Expressive\Container\NotFoundHandlerFactory',
    ],
];
