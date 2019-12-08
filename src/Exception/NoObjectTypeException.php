<?php


namespace Hubspot\Psr7\Exception;


use Throwable;

class NoObjectTypeException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = 'Adding object type data is required.';

        parent::__construct($message, $code, $previous);
    }
}