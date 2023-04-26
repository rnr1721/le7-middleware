<?php

declare(strict_types=1);

namespace Core\RequestHandler;

use Core\Interfaces\MiddlewareHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DefaultHandler implements MiddlewareHandler
{

    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->response;
    }

    public function withResponse(ResponseInterface $response): MiddlewareHandler
    {
        return new self($response);
    }
    
}
