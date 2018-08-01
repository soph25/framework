<?php

namespace Framework;

use DI\ContainerBuilder;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouteCollector;
use Zend\Expressive\Router\FastRouteRouter;
use Framework\Router;
use Framework\Router\MiddlewareApp;
use Framework\MiddlewarePipeInterface;
use Framework\MiddlewarePipe;
use Zend\Expressive\Router\Route as ZendRoute;
use Framework\Router\Route;
use Framework\Middleware\CombinedMiddleware;


use function Framework\Path;

class App implements MiddlewareInterface, RequestHandlerInterface
{

    private $path;
    /**
     * List of modules
     * @var array
     */
    private $modules = [];
    /**
     * @var string
     */
    
    private $definition;
    /**
     * @var ContainerInterface
     */
    private $container;

    private $factory;
    

    public $router;
    /**
     * @var string[]
     */
    private $middlewares = [];
    
    private $httpRouteMethods = [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
    ];
    /**
     * @var int
     */
    private $index = 0;

    public function __construct($definition = null)
    {
        $this->definition = $definition;
    }
    
    /**
     * Rajoute un module à l'application
     *
     * @param string $module
     * @return App
     */
    public function addModule(string $module): self
    {
        //var_dump($this->getContainer()->get($module));
        $this->modules[] = $module;
        return $this;
    }
    
    public function view(string $some)
    {
    }

    
    /**
     * Ajoute un middleware
     *
     * @param string $middleware
     * @return App
     */
    public function pipe($routePrefix, $middleware = null): self
    {
        if ($middleware === null) {
            $this->middlewares[] = $routePrefix;
        } else {
            $this->middlewares[] = new RoutePrefixedMiddleware($this->getContainer(), $routePrefix, $middleware);
        }
        return $this;
    }
    
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $middleware = new CombinedMiddleware($this->getContainer(), $this->middlewares);

        return $middleware->handle($request);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler = null): ResponseInterface
    {
        $this->index++;
        if ($this->index > 1) {
            throw new \Exception();
        }
        $middleware = new CombinedMiddleware($this->getContainer(), $this->middlewares);

        return $middleware->process($request, $this);
    }




    

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        
        foreach ($this->modules as $module) {
            $this->getContainer()->get($module);
        }
        return $this->process($request);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            $builder = new ContainerBuilder();
            //$builder->addDefinitions($this->definition);
            if ($this->definition) {
                $builder->addDefinitions($this->definition);
            }
            foreach ($this->modules as $module) {
                if ($module::DEFINITIONS) {
                    $builder->addDefinitions($module::DEFINITIONS);
                }
            }
            $this->container = $builder->build();
        }
        return $this->container;
    }

    /**
     * @return object
     */
    public function getModules(): array
    {
        return $this->modules;
    }
}
