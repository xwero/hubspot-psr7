<?php


namespace Hubspot\Psr7\Response;


use Hubspot\Psr7\Exception\BadContactsException;
use Psr\Http\Message\ResponseInterface;

class ContactsResponse
{
    private $response;

    public function __construct(ResponseInterface $response)
    {
        if($response->getStatusCode() > 204) {
            throw (new BadContactsException())->handleResponse($response);
        }

        $this->response = $response;
    }

    public function getContactPropertyValue(string $property)
    {
        $contact = $this->jsonFromResponse();

        if(isset($contact->properties->{$property}->value)) {
            return $contact->properties->{$property}->value;
        }

        return '';
    }

    public function isContactCreated()
    {
        return $this->response->getStatusCode() === 200;
    }

    public function isContactDeleted()
    {
        return $this->response->getStatusCode() === 200;
    }

    public function areContactsCreated()
    {
        return $this->response->getStatusCode() === 202;
    }

    public function isContactUpdated()
    {
        return $this->response->getStatusCode() === 204;
    }

    private function jsonFromResponse()
    {
        $data = (string) $this->response->getBody();
        return json_decode($data);
    }
}