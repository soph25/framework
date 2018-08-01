<?php
/**
 * @see       https://github.com/zendframework/zend-stratigility for the canonical source repository
 * @copyright Copyright (c) 2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-stratigility/blob/master/LICENSE.md New BSD License
 */



namespace Framework;

use Psr\Http\Server\MiddlewareInterface;
use Framework\PathMiddlewareDecorator;

/**
 * Convenience function for creating path-segregated middleware.
 *
 * Usage:
 *
 * <code>
 * use function Zend\Stratigility\path;
 *
 * $pipeline->pipe(path('/foo', $middleware));
 * </code>
 */
function Path(string $path, MiddlewareInterface $middleware) : PathMiddlewareDecorator
{
    return new PathMiddlewareDecorator($path, $middleware);
}
