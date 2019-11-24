<?php


namespace Hubspot\Psr7\Exception;


use Throwable;

class BadContactsException extends \Exception
{
    public function handleResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        switch($response->getStatusCode()){
            case 400:
                $this->message = 'Bad data';
                break;
            case 401:
                $this->message = 'Unauthorized';
                break;
            case 404:
                $this->message = 'Does not exist';
                break;
            case 409:
                $this->message = 'Conflict';
                break;
            case 500:
                $this->message = 'Server error';
                break;
        }
    }
}