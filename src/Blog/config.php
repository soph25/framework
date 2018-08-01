<?php

use App\Blog\BlogModule;
use function \Di\object;
use function \Di\get;

return [
    'admin.prefix' => '/admin',
    'admin.widgets' => \DI\add([
        get(\App\Blog\BlogWidget::class)
    ]),
    'blog.path' => '/home/sophie/monp/src/Blog/views',
    BlogModule::class => object()->constructorParameter('prefix', get('blog.prefix'))->constructorParameter('path', \DI\get('blog.path'))
 
];
