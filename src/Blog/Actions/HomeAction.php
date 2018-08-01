<?php
namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RenderInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Framework\Router;
use League\Plates\Engine;

class HomeAction
{

    private $container;

    private $router;
    /**
     * @var RendererInterface
     */
    private $renderer;

    public function __construct(Router $router, RenderInterface $renderer, ContainerInterface $container)
    {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->container = $container->get('home');
    }

    public function __invoke(Request $request)
    {
       
        
        return $this->home();
    }

    public function home(): string
    {
        return $this->container->render('home', ['name' => 'Jonathan', 'router' => $this->router]);
    }
}
