<?php

namespace Core\Interfaces;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface MiddlewareHandlerInterface extends RequestHandlerInterface
{

    public function withResponse(ResponseInterface $response): MiddlewareHandlerInterface;
}
