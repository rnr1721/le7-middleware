# le7-middleware
PSR-15 Middleware implementation for le7 MVC PHP framework or any PHP project

## What it can?

It is a standard implementation of PSR-15 interfaces. You can read more at
https://www.php-fig.org/psr/psr-15/

## How use it?

```php

use Core\RequestHandler\MiddlewareDispatcherGeneric;

        // $responseFactory is implementation of ResponseFactoryInterface
        $response = $responseFactory->createResponse(404);
        $defaultRequestHandler = new DefaultHandler($response);
        $middlewares = new MiddlewareDispatcherDefault($defaultRequestHandler);

        // Middlewares are implementation of MiddlewareInterface
        $middleware1 = new Middleware1();
        $middleware2 = new Middleware2();
        $middleware3 = new Middleware3();
        $middleware4 = new Middleware4();

        // If need to run in reverse order
        $middleware->setReverse(true);

        // Add middlewares. It will be run in reverse order (if turn on):
        // Default Handler at first, and 4,3,2,1 after
        $middlewares->add($middleware1);
        $middlewares->add($middleware2);
        $middlewares->add($middleware3);
        $middlewares->add($middleware4);

        // Get response after process middlewares
        // $request is PSR Request
        $response = $middlewares->handle($request);

```

## Clean middleware example

```php

<?php

declare(strict_types=1);

namespace Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        return $response;
    }

}

```

## Usage example

```php

<?php

declare(strict_types=1);

namespace Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        return $response->withStatus(201);
    }

}

```

```php

<?php

declare(strict_types=1);

namespace Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        
        // do something

        // To next handler
        return $handler->handle($request);
    }

}

```
