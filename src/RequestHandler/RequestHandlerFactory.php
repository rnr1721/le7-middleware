<?php

declare(strict_types=1);

namespace Core\RequestHandler;

use Core\Interfaces\MiddlewareDispatcherInterface;
use Core\RequestHandler\MiddlewareDispatcherDefault;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Container\ContainerInterface;

class RequestHandlerFactory
{

    private ResponseFactoryInterface $responseFactory;
    private ContainerInterface $container;

    public function __construct(
            ContainerInterface $container,
            ResponseFactoryInterface $responseFactory
            )
    {
        $this->container = $container;
        $this->responseFactory = $responseFactory;
    }

    public function usingContainer(array $middleware): MiddlewareDispatcherInterface
    {
        $response = $this->responseFactory->createResponse(404);
        $defaultHandler = new DefaultHandler($response);

        $middlewares = new MiddlewareDispatcherDefault($defaultHandler);

        foreach ($middleware as $class) {
            $item = $this->container->get($class);
            $middlewares->add($item);
        }

        return $middlewares;
    }

}
