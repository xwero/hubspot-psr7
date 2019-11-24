<?php


namespace Hubspot\Psr7\Builder;


use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestInterface;

class AuthorisationBuilder implements AuthorisationInterface
{
    const TYPE_KEY = 1;
    const TYPE_OAUTH = 2;

    private $type;
    private $value;

    public function __construct($type, string $value = '')
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function addAccessToken($token)
    {
        $this->value = $token;
    }


    public function addToRequest(RequestInterface $request)
    {
        if($this->type === self::TYPE_KEY) {
            return $request;
        }

        return $request->withHeader('AuthorisationInterface', 'Bearer ' . $this->value);
    }

    public function addToQueryString(string $queryString)
    {
        $hasValue = strlen($queryString) > 0;

        if($this->type === self::TYPE_OAUTH) {
            return $hasValue ? '?' : '';
        }

        $querystringSuffix = '?hapikey=' . $this->value;
        return $hasValue ? $querystringSuffix . '&' . $queryString : $querystringSuffix;
    }

    public function getAuthorisationTokenRequest($clientId, $clientSecret, $redirectUri, $authorisationCode)
    {
        $data = [
            'grant_type' => 'authorization_code',
            'code' => $authorisationCode
        ];

        return $this->getTokenRequest($clientId, $clientSecret, $redirectUri, $data);
    }

    public function getRefreshTokenRequest($clientId, $clientSecret, $redirectUri, $authorisationCode)
    {
        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $authorisationCode
        ];

        return $this->getTokenRequest($clientId, $clientSecret, $redirectUri, $data);
    }

    private function getTokenRequest($clientId, $clientSecret, $redirectUri, array $tokenGrantData) {
        if($this->type === self::TYPE_KEY) {
            return NULL;
        }

        $psr17Factory = new Psr17Factory();
        $endpoint = 'https://api.hubapi.com/oauth/v1/token';
        $request = $psr17Factory->createRequest('POST', $endpoint);
        $data = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
        ];

        $data = array_merge($data, $tokenGrantData);

        $bodyStream = $psr17Factory->createStream( json_encode($data));
        $request = $request->withBody($bodyStream);
        $request = $request->withHeader('Content-Type', 'application/json');

        return $request;
    }
}