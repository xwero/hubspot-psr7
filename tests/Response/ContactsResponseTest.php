<?php


use Hubspot\Psr7\Response\ContactsResponse;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

class ContactsResponseTest extends TestCase
{

    public function testGetContactPropertyValue()
    {
        $contact = [
            'properties' => [
                'test' => [
                    'value' => 'value'
                ]
            ]
        ];

        $psr17Factory = new Psr17Factory();
        $body = $psr17Factory->createStream(json_encode($contact));
        $response = $psr17Factory->createResponse();
        $response = $response->withBody($body);

        $this->assertSame('value', (new ContactsResponse($response))->getContactPropertyValue('test'));
    }
}
