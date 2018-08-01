<?php
namespace Framework\Plate;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap4View;
use Framework\Router;

class FantaPager implements ExtensionInterface
{
     public function __construct(Router $router)
    {
        $this->router = $router;
        
    }

    public function addLink($ref, $url)
    {
        $this->_links[$ref] = $url;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('paginate', [$this, 'paginate']);
        $engine->registerFunction('addLink', [$this, 'addLink']);
    }

    public function paginate(
        Pagerfanta $paginatedResults,
        string $route,
        array $routerParams = [],
        array $queryArgs = []
    ): string {
    
        $view = new TwitterBootstrap4View();
        return $view->render($paginatedResults, function (int $page) use ($route, $routerParams, $queryArgs) {
            if ($page > 1) {
                $queryArgs['p'] = $page;
            }
            return $this->router->generateUri($route, $routerParams, $queryArgs);
        });
    }
}
