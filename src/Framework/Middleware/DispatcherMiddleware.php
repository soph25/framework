<?php
namespace Framework\Middleware;

use Framework\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Middleware\CombinedMiddleware;

class DispatcherMiddleware implements MiddlewareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $delegate): ResponseInterface
    {
        $route = $request->getAttribute(Router\Route::class);

        if (is_null($route)) {
            return $delegate->process($request);
        }
        $callback = $route->getCallback();

        if (!is_array($callback)) {
            $callback = [$callback];
        }
        return (new CombinedMiddleware($this->container, $callback))->process($request, $delegate);
    }
}
