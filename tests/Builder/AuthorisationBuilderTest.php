<?php


use Hubspot\Psr7\Builder\AuthorisationBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

class AuthorisationBuilderTest extends TestCase
{

    public function testGetRefreshTokenRequest()
    {
        $auth = new AuthorisationBuilder(AuthorisationBuilder::TYPE_OAUTH);
        $accessTokenRequest = $auth->getRefreshTokenRequest('clientId', 'clientSecret', 'redirect', 'code');

        $this->assertSame('/oauth/v1/token', $accessTokenRequest->getRequestTarget());
    }

    public function testGetAuthorisationTokenRequest()
    {
        $auth = new AuthorisationBuilder(AuthorisationBuilder::TYPE_OAUTH);
        $accessTokenRequest = $auth->getAuthorisationTokenRequest('clientId', 'clientSecret', 'redirect', 'code');

        $this->assertSame('/oauth/v1/token', $accessTokenRequest->getRequestTarget());
    }

    public function testAddToRequest()
    {
        $request = (new Psr17Factory())->createRequest('POST', 'http://test.test');
        $auth = new AuthorisationBuilder(AuthorisationBuilder::TYPE_OAUTH, 'abc');
        $changedRequest = $auth->addToRequest($request);

        $this->assertStringContainsString('abc', $changedRequest->getHeader('AuthorisationInterface')[0]);
    }

    public function testAddToQueryStringTheApiKey()
    {
        $auth = new AuthorisationBuilder(AuthorisationBuilder::TYPE_KEY, 'abc');
        $queryString = 'a=b';

        $this->assertSame('?hapikey=abc&a=b', $auth->addToQueryString($queryString));
    }

    public function testAddToQueryStringOnlyTheApiKey()
    {
        $auth = new AuthorisationBuilder(AuthorisationBuilder::TYPE_KEY, 'abc');
        $queryString = '';

        $this->assertSame('?hapikey=abc', $auth->addToQueryString($queryString));
    }

    public function testAddToQueryStringNothing()
    {
        $auth = new AuthorisationBuilder(AuthorisationBuilder::TYPE_OAUTH, 'abc');
        $queryString = '';

        $this->assertEmpty($auth->addToQueryString($queryString));
    }
}
