<?php

declare(strict_types=1);

use Middleware\Middleware1;
use Middleware\Middleware2;
use Middleware\Middleware3;
use Middleware\Middleware4;
use Core\RequestHandler\DefaultHandler;
use Core\RequestHandler\MiddlewareDispatcherDefault;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

class MiddlewareTest extends PHPUnit\Framework\TestCase
{

    private ResponseFactoryInterface $responseFactory;
    private ServerRequestFactoryInterface $requestFactory;

    protected function setUp(): void
    {
        $this->requestFactory = new Psr17Factory();
        $this->responseFactory = new Psr17Factory();
    }

    public function testMiddleware()
    {
        $r = $this->createServerRequest('https://example.com/test/test1', 'GET');

        $response = $this->responseFactory->createResponse(404);
        $defaultRequestHandler = new DefaultHandler($response);
        $middlewares = new MiddlewareDispatcherDefault($defaultRequestHandler);

        $middleware1 = new Middleware1();
        $middleware2 = new Middleware2();
        $middleware3 = new Middleware3();
        $middleware4 = new Middleware4();
        $middlewares->add($middleware1);
        $middlewares->add($middleware2);
        $middlewares->add($middleware3);
        $middlewares->add($middleware4);
        $middlewares->setReverse(true);
        $response = $middlewares->handle($r);

        $response->getBody()->rewind();

        $waitHeaders = [
            'header1' => ['header1value']
        ];

        $this->assertEquals($response->getStatusCode(), 201);
        $this->assertEquals($response->getBody()->getContents(), 'response body141');
        $this->assertEquals($response->getHeaders(), $waitHeaders);
    }

    public function createServerRequest(
            string $uri,
            string $method = 'GET',
            array $data = []
    ): ServerRequestInterface
    {
        $headers = array_merge([
            'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'HTTP_ACCEPT_CHARSET' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
            'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.8',
            'HTTP_HOST' => 'localhost',
            'HTTP_USER_AGENT' => 'le7 Framework',
            'QUERY_STRING' => '',
            'REMOTE_ADDR' => '127.0.0.1',
            'REQUEST_METHOD' => $method,
            'REQUEST_TIME' => time(),
            'REQUEST_TIME_FLOAT' => microtime(true),
            'REQUEST_URI' => '',
            'SCRIPT_NAME' => '/index.php',
            'SERVER_NAME' => 'localhost',
            'SERVER_PORT' => 80,
            'SERVER_PROTOCOL' => 'HTTP/1.1',
                ], $data);

        return $this->requestFactory->createServerRequest($method, $uri, $headers);
    }

}
