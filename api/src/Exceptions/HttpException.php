<?php


namespace App\Exceptions;


use Exception;
use Fig\Http\Message\StatusCodeInterface;

class HttpException extends Exception
{
    public $code = StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR;
    public $message = 'Server Error';
}