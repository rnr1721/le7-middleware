<?php

declare(strict_types=1);

namespace Core\RequestHandler;

use Core\Interfaces\MiddlewareHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareHandlerDefault implements MiddlewareHandlerInterface
{

    private MiddlewareInterface $middleware;
    public MiddlewareHandlerInterface $requestHandler;

    public function __construct(
            MiddlewareInterface $middleware,
            MiddlewareHandlerInterface $requestHandler
            )
    {
        $this->middleware = $middleware;
        $this->requestHandler = $requestHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->middleware->process($request, $this->requestHandler);
    }

    public function withResponse(ResponseInterface $response): MiddlewareHandlerInterface
    {
        /** @var MiddlewareHandlerInterface $ */
        $newHandler = clone $this;
        
        $newHandler->requestHandler = $newHandler->requestHandler->withResponse($response);
        return $newHandler;
    }
    
}
