<?php
return [
    'templates' => [
         'paths' => [
             'app' =>  'templates',
             'error' => __DIR__ .'templates' 
            // namespace / path pairs
            //
            // Numeric namespaces imply the default/main namespace. Paths may be
            // strings or arrays of string paths to associate with the namespace.
        ],
    ],
    'twig' => [
        'cache_dir' => 'path to cached templates',
        'assets_url' => 'base URL for assets',
        'assets_version' => 'base version for assets',
        'extensions' => [
            // extension service names or instances
        ],
        'globals' => [
            // Global variables passed to twig templates
            'ga_tracking' => 'UA-XXXXX-X'
        ],
    ],
];
