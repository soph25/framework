<?php

namespace Framework\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Container\ContainerInterface;

class CombinedMiddlewareDelegate implements MiddlewareInterface
{
    private $container;
 
    private $middlewares = [];

    private $index = 0;

    private $delegate;

    public function __construct(ContainerInterface $container, array $middlewares, RequestHandlerInterface $delegate)
    {
          $this->middlewares = $middlewares;
          $this->container = $container;
          $this->delegate = $delegate;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        
           $middleware = $this->getMiddleware();
        if (is_null($middleware)) {
              return $this->delegate->process($request);
        } elseif (is_callable($middleware)) {
                 return call_user_func_array($middleware, [$request, [$this, 'process']]);
        } elseif ($middleware instanceof MiddlewareInterface) {
            return $middleware->process($request, $handler);
        }
    }

    private function getMiddleware()
    {
        if (array_key_exists($this->index, $this->middlewares)) {
            if (is_string($this->middlewares[$this->index])) {
                $middleware = $this->container->get($this->middlewares[$this->index]);
            } else {
                $middleware = $this->middlewares[$this->index];
            }
                 $this->index++;
                return $middleware;
        }
                return null;
    }
}
