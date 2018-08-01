<?php
namespace Tests\Framework\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WellRESTed\Message\Response;
use WellRESTed\Test\TestCases\MiddlewareTestCase;

class CombinedMiddlewareTest extends MiddlewareTestCase
{
  public function setUp()
  {
    parent::setUp();
    
    // Configure the default request.
    $this->request = $this->request
      ->withAttribute('id', 12345);

    // Configure the upstream handler the middleware may call.
    // Set the `response` member to the respone the handler should return.
    $this->handler->response = new Response(200);
  }

  protected function getMiddleware(): MiddlewareInterface
  {
    // Return a configured instance of the middleware under test.
    return new MyMiddleware();
  }

  public function testDelegatesToUpstreamHandler()
  {
    // Call `dispatch` to send the request to the middleware under test and 
    // return the response.
    $response = $this->dispatch();

    // You can make assertions on the `handler` member to check if the upstream
    // handler was called.

    // The `called` member will be true if the handler was called.
    $this->assertTrue($this->handler->called);
    // The `request` member will be set with the request passed to the handler.
    $this->assertSame($this->request, $this->handler->request);
  }
}

