<?php

namespace Core\Middleware\Interfaces;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface MiddlewareDispatcher extends RequestHandlerInterface
{
    /**
     * Add own middleware
     * Middlewares will run in reverse order
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function add(MiddlewareInterface $middleware): self;
}
