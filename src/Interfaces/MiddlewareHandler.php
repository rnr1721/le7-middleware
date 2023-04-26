<?php

namespace Core\Interfaces;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface MiddlewareHandler extends RequestHandlerInterface
{

    public function withResponse(ResponseInterface $response): MiddlewareHandler;
}
