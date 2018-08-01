<?php
namespace App\Blog;

use App\Blog\Actions\HomeAction;
use App\Blog\Actions\BlogAction;
use App\Blog\Actions\AdminBlogAction;
use App\Blog\Table\PostTable;
use Framework\Module;
use Framework\Renderer\RenderInterface;
use League\Plates\Engine;
use Framework\Router\Route;
use Framework\Router;
use Framework\Cache;
use Framework\Middleware\NotFoundMiddleware;
use Psr\Http\Message\ServerRequestInterface;

use Psr\Container\ContainerInterface;
use App\Blog\PostUpload;

class BlogModule extends Module
{

    public const DEFINITIONS = __DIR__ . '/config.php';

    const MIGRATIONS =  __DIR__ . '/db/migrations';

    const SEEDS =  __DIR__ . '/db/seeds';

    private $routes = [];

    public function __construct(string $path, string $prefix, Router $router, RenderInterface $renderer, ContainerInterface $container, PostTable $table, \Framework\Session\FlashService $flash, Cache $cache, PostUpload $upload)
    {
        //$renderer->addFolder('/home/sophie/monp/src/Blog', __DIR__ . '/views');
        //var_dump($path);
        //$router->get("/", new HomeAction($renderer, $router), 'blog.home');
         
        $pam =  $router->get("/", new HomeAction($router, $renderer, $container, $cache), 'blog.home');
        //$pam = $pom->getMiddleware();
        //var_dump($pam);
        //var_dump($router->match($request));
        $router->get($container->get('blog.prefix'), new BlogAction($router, $renderer, $container, $table, $cache), 'blog.index');
        //$router->get("/admin", new AdminBlogAction($router, $renderer, $container, $table), 'blog.admin');
        //$router->get($prefix, NotFoundMiddleware::class   , new BlogAction($router, $renderer, $container, $table, $cache), [] ,'blog.index');
        $router->get($prefix . '/{slug:[a-z\-0-9]+}-{id:[0-9]+}', new BlogAction($router, $renderer, $container, $table, $cache), 'blog.show');
        //$router->middleware();
        //if ($container->has('admin.prefix')) {
            //$prefix = $container->get('admin.prefix');
        $router->crud("/admin/posts", new AdminBlogAction($router, $renderer, $container, $table, $flash, $upload), 'blog.admin');

        
        //}
    }

    public function getRoutes()
    {
    }
}
