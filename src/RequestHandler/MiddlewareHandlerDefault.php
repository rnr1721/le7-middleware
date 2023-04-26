<?php

declare(strict_types=1);

namespace Core\RequestHandler;

use Core\Interfaces\MiddlewareHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareHandlerDefault implements MiddlewareHandler
{

    private MiddlewareInterface $middleware;
    public MiddlewareHandler $requestHandler;

    public function __construct(MiddlewareInterface $middleware, MiddlewareHandler $requestHandler)
    {
        $this->middleware = $middleware;
        $this->requestHandler = $requestHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->middleware->process($request, $this->requestHandler);
    }

    public function withResponse(ResponseInterface $response): MiddlewareHandler
    {
        /** @var MiddlewareHandler $ */
        $newHandler = clone $this;
        
        $newHandler->requestHandler = $newHandler->requestHandler->withResponse($response);
        return $newHandler;
    }
    
}
