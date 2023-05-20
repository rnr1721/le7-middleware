<?php

namespace Core\Interfaces;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface MiddlewareDispatcherInterface extends RequestHandlerInterface
{
    /**
     * Add own middleware
     * Middlewares will run in reverse order
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function add(MiddlewareInterface $middleware): self;
    
    /**
     * Set reverse order of middleware execution
     * @param bool $on
     * @return void
     */
    public function setReverse(bool $on):void;
    
    /**
     * Get names array of already added middleware
     * @return array
     */
    public function getReadyNames(): array;
}
