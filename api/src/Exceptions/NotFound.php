<?php


namespace App\Exceptions;


use Fig\Http\Message\StatusCodeInterface;

class NotFound extends HttpException
{
    public $code = StatusCodeInterface::STATUS_NOT_FOUND;
    public $message = 'Not Found';
}