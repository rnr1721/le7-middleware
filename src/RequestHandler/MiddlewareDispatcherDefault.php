<?php

declare(strict_types=1);

namespace Core\RequestHandler;

use Core\Interfaces\MiddlewareHandlerInterface;
use Core\Interfaces\MiddlewareDispatcherInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Handles a server request and produces a response.
 *
 * An HTTP request handler process an HTTP request in order to produce an
 * HTTP response.
 */
class MiddlewareDispatcherDefault implements MiddlewareDispatcherInterface
{

    private MiddlewareHandlerInterface $defaultHandler;
    private array $middlewares = [];
    private bool $reverseOrder = false;

    public function __construct(MiddlewareHandlerInterface $defaultRequestHandler)
    {
        $this->defaultHandler = $defaultRequestHandler;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        /** @var MiddlewareHandlerInterface $element */
        $element = $this->defaultHandler;

        if ($this->reverseOrder) {
            $middlewares = array_reverse($this->middlewares);
        } else {
            $middlewares = $this->middlewares;
        }

        foreach ($middlewares as $middleware) {
            $element = new MiddlewareHandlerDefault($middleware, $element);
        }

        return $element->handle($request);
    }

    /**
     * Add own middleware
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function add(MiddlewareInterface $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function setReverse(bool $on): void
    {
        $this->reverseOrder = $on;
    }

    public function getReadyNames(): array
    {
        $output = [];
        if ($this->reverseOrder) {
            $result = array_reverse($this->middlewares);
        } else {
            $result = $this->middlewares;
        }
        foreach ($result as $item) {
            $output[] = get_class($item);
        }
        return $output;
    }

}
