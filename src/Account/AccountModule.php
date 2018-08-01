<?php
namespace App\Account;

use App\Account\Action\SignupAction;
use App\Account\Action\AccountAction;
use Framework\Module;
use Framework\Renderer\RenderInterface;
use Framework\Router;
use Psr\Container\ContainerInterface;
use Framework\Auth\LoggedInMiddleware;
use App\Auth\ForbiddenMiddleware;

class AccountModule extends Module
{

    const DEFINITIONS = __DIR__ . '/definitions.php';

    public function __construct(Router $router, RenderInterface $renderer, ContainerInterface $container)
    {
        $renderer->addPath('account', __DIR__ . '/views');
        $router->get('/inscription', $container->get(SignupAction::class), 'account.signup');
        $router->post('/inscription', $container->get(SignupAction::class));
  //$router->get('/mon-profil', [$container->get(LoggedInMiddleware::class), $container->get(AccountAction::class)], 'account.profile');
        $router->get('/mon-profil', [LoggedInMiddleware::class, AccountAction::class], 'account.profile');
        $router->post('/mon-profil', [LoggedInMiddleware::class, AccountEditAction::class]);
    }
}
