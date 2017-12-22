<?php

namespace App\Action;

use Interop\Http\Server\RequestHandlerInterface;
use Interop\Http\Server\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class PingAction implements ServerMiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new JsonResponse(['ack' => time()]);
    }
}
