<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, "fr_FR");

use Framework\Foo;

use App\Admin\AdminModule;
use App\Auth\AuthModule;
use App\Blog\BlogModule;
use Framework\Middleware\{
    DispatcherMiddleware,
    MethodMiddleware,
    RouterMiddleware,
    CsrfMiddleware,
    TrailingSlashMiddleware,
    NotFoundMiddleware
};
use Doctrine\Common\Cache\ApcuCache;
use Doctrine\Common\Cache\FilesystemCache;
use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Request;
use Zend\Expressive\Router\FastRouteRouter;
use Framework\MiddlewareFactory;
use Framework\MiddlewareContainer;
use Framework\Session\SessionInterface;
use Framework\MiddlewarePipeInterface;
use Framework\MiddlewarePipe;

require dirname(__DIR__) . '/src/Framework/Loader.php';

$loader = new Loader('Framework', '/home/sophie/monp/src');


$loader->register();

//function crier(closure $closure): string
//{
  //return strtoupper($closure());
//}

//$foo = new \Framework\Demo();
//call_user_func_array(array($foo, "bar"), array("three", "four"));
//echo crier(Closure::fromCallable([$demo, "hello"]));


require dirname(__DIR__) . '/vendor/autoload.php';

$app = (new \Framework\App(dirname(__DIR__) .'/config/config.php'))
    ->addModule(AdminModule::class)
    ->addModule(BlogModule::class)
    ->addModule(AuthModule::class)
    ->addModule(\App\Account\AccountModule::class);

$container = $app->getContainer();
//$app->pipe(\Middlewares\Whoops::class)
$app->pipe(TrailingSlashMiddleware::class)
    ->pipe(\App\Auth\ForbiddenMiddleware::class)
    ->pipe($container->get('admin.prefix'), \Framework\Auth\LoggedInMiddleware::class)
    ->pipe(MethodMiddleware::class)
    ->pipe(CsrfMiddleware::class)
    ->pipe(RouterMiddleware::class)
    ->pipe(DispatcherMiddleware::class)
    ->pipe(NotFoundMiddleware::class);





//$container = $app->getCont();

//var_dump($app->getMiddleware());



if (php_sapi_name() !== "cli") {
    $response = $app->run(ServerRequest::fromGlobals());
    \Http\Response\send($response);
}

