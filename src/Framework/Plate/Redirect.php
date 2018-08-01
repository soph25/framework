<?php
namespace Framework\Plate;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap4View;
use Framework\Router;
use Psr\Http\Message\ResponseInterface as Response;

class Redirect implements ExtensionInterface 
{
     public function __construct(Router $router)
    {
        $this->router = $router;
        
    }
    public function register(Engine $engine)
    {
        $engine->registerFunction('redirect', [$this, 'redirect']);
    }

     public function redirect($path, Response $response)
    {
        $response = new Response();
        //$uri = $this->container->get('uri');
        //var_dump($router);
        //die();
        return $response->withRedirect($path);
    }

    
}
