<?php


namespace App\Exceptions;


use Exception;

class HttpException extends Exception
{
    public $code = 500;
    public $message = 'Server Error';
}