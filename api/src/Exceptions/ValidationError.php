<?php


namespace App\Exceptions;


class ValidationError extends HttpException
{
    public $code = 422;
    public $message = 'Unprocessable Entity';
}