<?php
namespace Tests\Framework;

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\Middleware\RouterMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\Framework\Modules\ErroredModule;
use Tests\Framework\Modules\StringModule;
use Psr\Http\Message\ServerRequestInterface;

class AppTest extends TestCase {

    private $app;

    public function setUp()
    {
        $this->app = new App();
    }

    
    
    public function testApp()
    {
        $this->app->addModule(get_class($this));
        $this->assertEquals([get_class($this)], $this->app->getModules());
    }

    public function testAppWithArrayDefinition()
    {
        $app = new App(['a' => 2]);
        $this->assertEquals(2, $app->getContainer()->get('a'));
    }

    public function testPipe()
    {
        $middleware = $this->getMockBuilder(MiddlewareInterface::class)->getMock();
        $middleware2 = $this->getMockBuilder(MiddlewareInterface::class)->getMock();
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $middleware->expects($this->once())->method('process')->willReturn($response);
        $middleware2->expects($this->never())->method('process')->willReturn($response);
        $this->assertEquals($response, $this->app->pipe($middleware)->run($request));
    }

    public function testPipeWithClosure()
    {
        $middleware = $this->getMockBuilder(MiddlewareInterface::class)->getMock();
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $middleware->expects($this->once())->method('process')->willReturn($response);
        $this->app
            ->pipe(function ($request, $next) {
                return $next($request);
            })
            ->pipe($middleware);
        $this->assertEquals($response, $this->app->run($request));
    }

    

    

    

}
