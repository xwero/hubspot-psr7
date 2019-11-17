<?php


namespace Hubspot\Psr7\Response;


use Psr\Http\Message\ResponseInterface;

class Contacts
{
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getContactPropertyValue(string $property)
    {
        $data = $this->response->getBody()->getContents();
        $contact = json_encode($data);

        if(isset($contact->properties->{$property}->value)) {
            return $contact->properties->{$property}->value;
        }

        return '';
    }
}