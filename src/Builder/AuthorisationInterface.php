<?php


namespace Hubspot\Psr7\Builder;


use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;

interface AuthorisationInterface
{
    public function addToRequest(RequestInterface $request);

    public function addToQueryString(string $queryString);
}