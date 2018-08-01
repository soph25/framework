<?php
namespace Framework\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareApp implements MiddlewareInterface
{
    private $call;
    /**
     * @var callable
     */
    private $callback = [];

    public function __construct($callback)
    {
        
        
        $this->callback = $callback;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface|null $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler = null): ResponseInterface
    {

        return call_user_func_array($this->call, [$request, [$this, 'process']]);
    }


    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }
}
