<?php
namespace App\Auth;

use App\Auth\Action\LoginAction;
use App\Auth\Action\LoginAttemptAction;
use App\Auth\Action\LogoutAction;
use App\Auth\Action\LogoutActionAction;
use Framework\Module;
use Framework\Renderer\RenderInterface;
use Framework\Router;
use Framework\Router\Route;
use Psr\Container\ContainerInterface;
use App\Auth\DatabaseAuth;
use Framework\Session\SessionInterface;
use Framework\Session\FlashService;

class AuthModule extends Module
{

    const DEFINITIONS = __DIR__ . '/config.php';

    const MIGRATIONS =  __DIR__ . '/db/migrations';

    const SEEDS =  __DIR__ . '/db/seeds';

    public function __construct(ContainerInterface $container, Router $router, RenderInterface $renderer, FlashService $service, DatabaseAuth $data, SessionInterface $session)
    {
        $renderer->addPath('auth', __DIR__ . '/views');
        $router->get($container->get('auth.login'),  new LoginAction($container, $renderer,$router ,$container), 'auth.login');
        
        $router->post($container->get('auth.login'), new LoginAttemptAction($container, $renderer, $router, $data, $session));
        $router->get('/logout', new LogoutAction($container, $renderer, $data, $service), 'auth.logout');
    }
}
