<?php
namespace App\Admin;

use App\Blog\Actions\HomeAction;
use App\Blog\Actions\BlogAction;
use App\Blog\Table\PostTable;
use Framework\Module;
use Framework\Renderer\RenderInterface;
use League\Plates\Engine;
use Framework\Router;
use Psr\Container\ContainerInterface;

class AdminModule extends Module
{

    const DEFINITIONS = __DIR__ . '/config.php';

    private $widgets;

    public function __construct(RenderInterface $renderer, Router $router, string $prefix, array $widgets, ContainerInterface $container)
    {
        $this->widgets = $widgets;
        $renderer->addPath('admin', __DIR__ . '/views');
        //var_dump($container->get('admin.prefix'));
        //die();
        //$renderer->addFolder('/home/sophie/monp/src/Blog', __DIR__ . '/views');
        $router->get('/admin', new DashboardAction($renderer, $this->widgets, $container), 'admin');
        //$router->get("/", new HomeAction($renderer, $router), 'blog.home');
    }
}
