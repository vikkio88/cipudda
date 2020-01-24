<?php


namespace App\Middlewares;


use Nicu\Constants\HttpStatusCodes;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthGuard
{
    private $routes;
    private $key;
    private $header;

    public function __construct($options)
    {
        $this->header = $options['header'];
        $this->routes = $options['routes'];
        $this->key = $options['key'];
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $method = $request->getMethod();
        $uri = parse_url($request->getUri(), PHP_URL_PATH);
        if ($this->requiresAuth($method, $uri) && !$this->isAuthenticated($request)) {
            return $response
                ->withStatus(HttpStatusCodes::UNAUTHORIZED)
                ->withHeader('Content-Type', 'application/json');
        }
        return $next($request, $response);
    }

    private function requiresAuth(string $method, string $uri)
    {
        if (!array_key_exists($method, $this->routes)) {
            return false;
        }

        foreach ($this->routes[$method] as $pattern) {
            if (preg_match($pattern, $uri)) {
                return true;
            }
        }

        return false;
    }

    private function isAuthenticated(RequestInterface $request)
    {
        return ($this->key === $request->getHeaderLine($this->header));
    }


}
