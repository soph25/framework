<?php
namespace Framework\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use GuzzleHttp\Psr7\Response;

class TrailingSlashMiddleware {

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri === "/") { 
           //return new Response(200, [], '<h1>Erreur 404</h1>');
           return $next($request);
        }
        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }
        return $next($request);
    }

}
