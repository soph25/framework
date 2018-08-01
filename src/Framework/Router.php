<?php

namespace Framework;

use Framework\Router\Route;
use Framework\Router\MiddleApp;
use Framework\Router\MiddlewareApp;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;
use Zend\Expressive\Router\RouteCollector;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;


/**
 * Register and match routes
 */
class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    private $middles = []; 

    public $routes = [];

    private $route;

    

    public function __construct()
    {
        
        $this->router = new FastRouteRouter();
        //$this->collector = new RouteCollector($this->router);
        
    }

    /**
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function get(string $path, $callable, ?string $name = null)
    {
        $rout = new ZendRoute($path, new MiddlewareApp($callable), ['GET'], $name);
        $this->router->addRoute($rout);
        return $rout;
    }


    

    public function middleware(Request $request, callable $next)
    {

        return $next($request);

    }
    

    public function getZendRouter()
    {
           return $this->router;
    }
     /**
     * @param string $path
     * @param string|callable $callable
     * @param string $name
     */

    public function post(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, new MiddlewareApp($callable), ['POST'], $name));
    }


    

    /**
     * @param string $path
     * @param string|callable $callable
     * @param string $name
     */
    public function delete(string $path, $callable, ?string $name = null)
    {
        //$this->router->addRoute(new ZendRoute($path, new MiddlewareApp($callable), ['DELETE'], $name));
        $delete = new ZendRoute($path, new MiddlewareApp($callable), ['DELETE'], $name);
        $this->router->addRoute($delete);
        return $delete;
         
    }

    /**
     * Génère les route du CRUD
     *
     * @param string $prefixPath
     * @param $callable
     * @param string $prefixName
     */
    public function crud(string $prefixPath, $callable, string $prefixName)
    {
        $this->get("$prefixPath", $callable, "$prefixName.index");
        $this->get("$prefixPath/new", $callable, "$prefixName.create");
        $this->post("$prefixPath/new", $callable);
        $this->get("$prefixPath/{id:\d+}", $callable, "$prefixName.edit");
        $this->post("$prefixPath/{id:\d+}", $callable);
        $this->delete("$prefixPath/{id:\d+}", $callable, "$prefixName.delete");
    }

   
    public function recup(array $publicMiddles): self
    {
        $this->middles = $publicMiddles;
//var_dump($this->middles);
        return $this;
    }

   

      public function setContainer(ContainerInterface $container)
    {
        
        $this->container = $container;
        //$middleware = $this->container->get(NotFoundMiddleware::class);
        return  $this->container;
    }
    /**
     * @param ServerRequestInterface $request
     * @return Route|null
     */
    public function match(Request $request): ?Route
    {
        $result = $this->router->match($request);
//echo "yes";
                
        if ($result->isSuccess()) {

            $route =  new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedRoute()->getMiddleware()->getCallback(),
                $result->getMatchedParams()
            );

            //var_dump($result->getMatchedRoute()->getMiddleware());
            //var_dump($route->getCall($result->getMatchedRoute()->getMiddleware()));
//die();
            //$some = $this->stock($route->getName());
            //array_push($this->routes, $route->getName());

        //echo $route->getName();
        //$route->getMiddleware();
            return $route;
        }
        return null;
    }

    private function stock($route): self
    {
        $this->routes[] = $route;
        return $this;
    }

    public function getStock()
    {
         return $this->routes;
    }

    public function generateUri(string $name, array $params = [], array $queryParams = []): ?string
    {
        $uri = $this->router->generateUri($name, $params);
        //$route   = $this->routes[$name];
        if (!empty($queryParams)) {
            return $uri . '?' . http_build_query($queryParams);
        }
        return $uri;
    }
}
