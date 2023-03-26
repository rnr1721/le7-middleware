<?php

declare(strict_types=1);

namespace Core\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Container\ContainerInterface;

class MiddlewaresFactory
{

    private ResponseFactoryInterface $responseFactory;
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container, ResponseFactoryInterface $responseFactory)
    {
        $this->container = $container;
        $this->responseFactory = $responseFactory;
    }

    public function usingContainer(array $middleware): Middlewares
    {
        $defaultHandler = new DefaultHandler($this->responseFactory);

        $middlewares = new Middlewares($defaultHandler);

        foreach ($middleware as $class) {
            $item = $this->container->get($class);
            $middlewares->add($item);
        }

        return $middlewares;
    }

}
