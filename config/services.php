<?php

use DI\ContainerBuilder;
use Framework\Renderer\RenderInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router\RouterTwigExtension;
use Framework\Session\PHPSession;
use Framework\Session\SessionInterface;
use Framework\Renderer\PlatesRendererFactory;
use Framework\Middleware\CsrfMiddleware;
use App\Blog\BlogModule;
use Zend\Expressive\Router\FastRouteRouter;

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions([
    'blog.prefix' => '/news',
    'admin.prefix' => '/admin',  
    'blog.path' => '/home/sophie/monp/src/Blog/views', 
    'database.host' => 'localhost',
    'database.username' => '',
    'database.password' => '',
    'database.name' => 'monsupersite',
    'views.path' => dirname(__DIR__) . '/views',
    'twig.extensions' => [
      \DI\get(RouterTwigExtension::class)
    ],
    SessionInterface::class => \DI\object(PHPSession::class),
    CsrfMiddleware::class => \DI\object()->constructor(\DI\get(SessionInterface::class)), 
    \Framework\Router::class => \DI\object()->constructor(\DI\get(FastRouteRouter::class)),
    //'home' => function (\Psr\Container\ContainerInterface $container) {
       //$vue =  new \League\Plates\Engine('/home/sophie/monp/views');
       //return $vue;  
     
    //},
     RenderInterface::class => \DI\factory(PlatesRendererFactory::class),
    
    'plates'   => function (\Psr\Container\ContainerInterface $container) {
     $path_info = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (!empty($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');
        //$dir = '/home/sophie/autre.fr';
        //var_dump($dir);
        //die();   
        $view =  new \League\Plates\Engine('/home/sophie/monp/src/Blog/views');
        $view->loadExtension(new \League\Plates\Extension\URI($path_info)); 
        $view->loadExtension(new \Framework\Plate\FantaPager(
        $container->get(\Framework\Router::class)
        
    ));
        $view->loadExtension(new \Framework\Plate\ChangeCase(
        $container->get(\Framework\Router::class)
    ));
    $view->loadExtension(new \Framework\Plate\TimeExtension(
        $container->get(\Framework\Router::class)
    ));
    $view->loadExtension(new \Framework\Plate\TextExtension(
        $container->get(\Framework\Router::class)
    ));

    //$view->loadExtension(new League\Plates\Extension\Asset('/home/sophie/autre.fr/public/uploads/posts/', false));
    return $view;  
        
    },
 
    //'plates' => \DI\object(\League\Plates\Engine::class)->constructor('/home/sophie/monp/src/Blog/views'),
    'home'  => \DI\object(\League\Plates\Engine::class)->constructor('/home/sophie/monp/views'),
    'badmin'   => function (\Psr\Container\ContainerInterface $container) {
      $path_info = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (!empty($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');  
      $vue =  new \League\Plates\Engine('/home/sophie/monp/src/Admin/views'); 
      $vue->loadExtension(new \League\Plates\Extension\URI($path_info)); 
      $vue->loadExtension(new \Framework\Plate\Flash($container->get(\Framework\Session\FlashService::class))); 
      $vue->loadExtension(new \Framework\Plate\Csrf($container->get(Framework\Middleware\CsrfMiddleware::class))); 
      $vue->loadExtension(new \Framework\Plate\FantaPager(
      $container->get(\Framework\Router::class)
         
    ));
    return $vue;  
    }, 
    //'badmin'  => \DI\object(\League\Plates\Engine::class)->constructor('/home/sophie/monp/src/Blog/views/admin'),  
    'blog.path' => '/home/sophie/monp/src/Blog',
    BlogModule::class => \Di\object()->constructorParameter('prefix', \DI\get('blog.prefix'))->constructorParameter('path', \DI\get('blog.path')),
    \PDO::class => function (\Psr\Container\ContainerInterface $c) {
        $DB = new \PDO('sqlite:/home/sophie/monp/monsupersite.sqlite3'); 
        $DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        return $DB;  
    }

]);

$container = $builder->build();

return $container;
