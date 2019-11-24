<?php


namespace Hubspot\Psr7\Exception;


use Throwable;

class RequiredQueryStringOptionsException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Not all required options where added to the QueryStringInterface.', $code, $previous);
    }
}