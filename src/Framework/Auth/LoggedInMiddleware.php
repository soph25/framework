<?php
namespace Framework\Auth;

use Framework\Auth;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoggedInMiddleware implements MiddlewareInterface
{

    /**
     * @var Auth
     */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $delegate): ResponseInterface
    {
        $user = $this->auth->getUser();


        if (is_null($user)) {
            throw new ForbiddenException();
        }
        return $delegate->process($request->withAttribute('user', $user));
    }
}
