<?php

namespace App\Account\Action;

use App\Auth\DatabaseAuth;
use App\Auth\User;
use App\Auth\UserTable;
use Framework\Database\Hydrator;
use Framework\Renderer\RenderInterface;
use Framework\Response\RedirectResponse;
use Framework\Router;
use Framework\Session\FlashService;
use Framework\Validator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;
use Framework\Actions\RouterAwareAction;

class AccountAction
{
    private $container;
    /**
     * @var RendererInterface
     */
    private $renderer;
    /**
     * @var UserTable
     */
    private $userTable;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var DatabaseAuth
     */
    private $auth;
    /**
     * @var FlashService
     */
    private $flashService;

    use RouterAwareAction;

    public function __construct(
        ContainerInterface $container,
        RenderInterface $renderer,
        UserTable $userTable,
        Router $router,
        DatabaseAuth $auth,
        FlashService $flashService
    ) {
        $this->container = $container->get('lobin');
        $this->renderer = $renderer;
        $this->userTable = $userTable;
        $this->router = $router;
        $this->auth = $auth;
        $this->flashService = $flashService;
    }

    public function __invoke(ServerRequestInterface $request)
    {

        return $this->container->render('accountprofile', [ 'user' => $this->auth->getUser() ]);        
   
        
    }
}
