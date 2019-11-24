<?php

use Hubspot\Psr7\Builder\AuthorisationBuilder;
use Hubspot\Psr7\Builder\ContactQueryStringBuilder;
use Hubspot\Psr7\Builder\EndpointBuilder;
use PHPUnit\Framework\TestCase;

class EndpointBuilderTest extends TestCase
{

    public function testSetVersion2()
    {
        $auth = new AuthorisationBuilder(AuthorisationBuilder::TYPE_KEY, 'a');
        $endpoint = new EndpointBuilder('/:apiversion', $auth);
        $endpoint->setVersion2();

        $this->assertSame('https://api.hubapi.com/v2?hapikey=a', $endpoint->getEndpoint());
    }


    public function testSetVersion3()
    {
        $auth = new AuthorisationBuilder(AuthorisationBuilder::TYPE_KEY, 'a');
        $endpoint = new EndpointBuilder('/:apiversion', $auth);
        $endpoint->setVersion3();

        $this->assertSame('https://api.hubapi.com/v3?hapikey=a', $endpoint->getEndpoint());
    }

    public function testSetQueryString()
    {
        $auth = new AuthorisationBuilder(AuthorisationBuilder::TYPE_KEY, 'a');
        $endpoint = new EndpointBuilder('/:apiversion', $auth);
        $qs = (new ContactQueryStringBuilder())->addId(1);

        $endpoint->setQueryString($qs);

        $this->assertSame('https://api.hubapi.com/v1?hapikey=a&vid=1', $endpoint->getEndpoint());
    }

    public function testSetReplacements()
    {
        $auth = new AuthorisationBuilder(AuthorisationBuilder::TYPE_KEY, 'a');
        $endpoint = new EndpointBuilder('/:apiversion/:id', $auth);

        $endpoint->setReplacements([':id' => 1]);

        $this->assertSame('https://api.hubapi.com/v1/1?hapikey=a', $endpoint->getEndpoint());
    }
}
