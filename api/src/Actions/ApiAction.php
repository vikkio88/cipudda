<?php


namespace App\Actions;

use App\Exceptions\HttpException;
use Psr\{
    Http\Message\RequestInterface,
    Http\Message\ResponseInterface
};
use Exception;
use Slim\Psr7\Request;


abstract class ApiAction
{
    protected $status = 200;
    protected $message = 'Ok';
    protected $payload = [];

    protected $request;
    protected $response;
    protected $args = [];

    protected $requestBody = null;
    protected $queryParams = null;

    public function get($key, $default = null)
    {
        //json body will override the query params that override the uri args
        $values = array_merge(
            $this->args,
            $this->getQueryParams(),
            $this->getRequestBody()
        );
        return $values[$key] ?? $default;
    }

    public function getRequestBody()
    {
        if (is_null($this->requestBody)) {
            $json = $this->request instanceof Request ?
                $this->request->getBody() : "";
            $this->requestBody = json_decode($json, true) ?? [];
        }
        return $this->requestBody;
    }

    public function getHeader($key)
    {
        return $this->request instanceof Request ?
            $this->request->getHeaderLine($key) : null;
    }

    public function getQueryParams()
    {
        if (is_null($this->queryParams)) {
            $this->queryParams = $this->request instanceof Request ?
                $this->request->getQueryParams() : [];
        }

        return $this->queryParams;
    }

    private function getArgsFromRequest(RequestInterface $request): array
    {
        $attributes = $request->getAttributes();
        return isset($attributes['route']) ?
            ($attributes['route'])->getArguments() : [];
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $this->getArgsFromRequest($request);
        return $this->execute();
    }

    public function execute():ResponseInterface
    {
        try {
            $this->payload = $this->action();
        } catch (HttpException $e) {
            $this->manageAppException($e);
        } catch (Exception $e) {
            $this->manageException($e);
        }

        return $this->respond($this->payload, $this->status, $this->message);
    }

    protected function manageAppException(HttpException $exception)
    {
        $this->status = $exception->code;
        $this->message = $exception->message;
        $this->payload = [
            'error' => $exception->getMessage()
        ];
    }

    protected function manageException(Exception $exception)
    {
        $this->status = 500;
        $this->message = 'Oopsie Woopsie';
        $this->payload = [
            'error' => $exception->getMessage()
        ];
    }

    abstract protected function action(): array;


    protected function respond($payload, $status, $message): ResponseInterface
    {
        $response = $this->response->withStatus($status)
            ->withHeader('Content-Type', 'application/json');

        $response->getBody()->write(
            json_encode(
                [
                    'status' => $status,
                    'message' => $message,
                    'payload' => $payload
                ]
            )
        );

        return $response;
    }
}