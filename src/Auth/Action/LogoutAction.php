<?php
namespace App\Auth\Action;

use App\Auth\DatabaseAuth;
use Framework\Renderer\RenderInterface;
use Framework\Response\RedirectResponse;
use Framework\Session\FlashService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

class LogoutAction
{
    private $container;
    /**
     * @var RendererInterface
     */
    private $renderer;
    /**
     * @var DatabaseAuth
     */
    private $auth;
    /**
     * @var FlashService
     */
    private $flashService;

    public function __construct(ContainerInterface $container, RenderInterface $renderer, DatabaseAuth $auth, FlashService $flashService)
    {
        $this->container = $container->get('lobin');
        $this->renderer = $renderer;
        $this->auth = $auth;
        $this->flashService = $flashService;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $this->auth->logout();
        $this->flashService->success('Vous êtes maintenant déconnecté');
        return new RedirectResponse('/');
    }
}
