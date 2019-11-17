<?php


namespace Hubspot\Psr7\Api;


use Nyholm\Psr7\Factory\Psr17Factory;

abstract class Base
{
    protected $apiKey;
    protected $psr17Factory;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->psr17Factory = new Psr17Factory();
    }
}