<?php


namespace App\Exceptions;


use Fig\Http\Message\StatusCodeInterface;

class ValidationError extends HttpException
{
    public $code = StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY;
    public $message = 'Unprocessable Entity';
}