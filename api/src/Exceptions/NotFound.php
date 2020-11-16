<?php


namespace App\Exceptions;


class NotFound extends HttpException
{
    public $code = 404;
    public $message = 'Not Found';
}