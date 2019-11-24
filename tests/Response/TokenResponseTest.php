<?php

use Hubspot\Psr7\Response\TokenResponse;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

class TokenResponseTest extends TestCase
{

    public function testGetAccessToken()
    {
        $psr17Factory = new Psr17Factory();
        $response = $psr17Factory->createResponse();
        $json = ['access_token' => 'a'];
        $body = $psr17Factory->createStream(json_encode($json));
        $response = $response->withBody($body);

        $this->assertSame('a', (new TokenResponse($response))->getAccessToken());
    }

    public function testGetAccessTokenError()
    {
        $psr17Factory = new Psr17Factory();
        $response = $psr17Factory->createResponse(400);
        $json = ['message' => 'a'];
        $body = $psr17Factory->createStream(json_encode($json));
        $response = $response->withBody($body);

        $this->expectException(\Hubspot\Psr7\Exception\BadTokenRequestException::class);
        $this->assertSame('a', (new TokenResponse($response))->getAccessToken());
    }

    public function testGetRefreshToken()
    {
        $psr17Factory = new Psr17Factory();
        $response = $psr17Factory->createResponse();
        $json = ['refresh_token' => 'a'];
        $body = $psr17Factory->createStream(json_encode($json));
        $response = $response->withBody($body);

        $this->assertSame('a', (new TokenResponse($response))->getRefreshToken());
    }
}
