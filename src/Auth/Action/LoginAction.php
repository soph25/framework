<?php
namespace App\Auth\Action;

use Framework\Renderer\RenderInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

class LoginAction
{
    private $container;
    /**
     * @var RendererInterface
     */
    private $renderer;

    public function __construct(ContainerInterface $container, RenderInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->container = $container->get('lobin');
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return $this->container->render('authlogin');
    }
}
