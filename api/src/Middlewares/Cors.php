<?php


namespace App\Middlewares;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Cors
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        $response = $handler->handle($request);
        if (!$request->getHeaderLine('origin')) {
            return $response;
        }

        return $response
            ->withHeader('Access-Control-Allow-Origin', $request->getHeaderLine('origin'))
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, X-Api-Key')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    }

}