<?php


namespace App\Middlewares;


use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Factory\ResponseFactory;

class AuthGuard
{
    private $key;
    private $header;

    public function __construct($options)
    {
        $this->header = $options['header'];
        $this->key = $options['key'];
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        if (!$this->isAuthenticated($request)) {
            $responseFactory = new ResponseFactory();
            return $responseFactory->createResponse(StatusCodeInterface::STATUS_UNAUTHORIZED)
                ->withHeader('Content-Type', 'application/json');
        }
        return $handler->handle($request);
    }


    private function isAuthenticated(RequestInterface $request)
    {
        return ($this->key === $request->getHeaderLine($this->header));
    }


}
