<?php


namespace Hubspot\Psr7\Request;


use Hubspot\Psr7\Builder\AuthorisationInterface;
use Nyholm\Psr7\Factory\Psr17Factory;

abstract class Base
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';
    const METHOD_PUT ='PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PATCH = 'PATCH';

    protected $authorisation;

    public function __construct(AuthorisationInterface $authorisation)
    {
        $this->authorisation = $authorisation;
    }

    protected function buildRequest(string $method, string $uri, $body = null)
    {
        $psr17Factory = new Psr17Factory();
        $request = $psr17Factory->createRequest($method, $uri);
        $request = $this->authorisation->addToRequest($request);

        if(is_array($body) || $body instanceof \JsonSerializable) {
            $body = $psr17Factory->createStream(json_encode($body));
            $request = $request->withBody($body);
        }

        return $request;
    }
}