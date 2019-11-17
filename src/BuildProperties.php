<?php


namespace Hubspot\Psr7;


use JsonSerializable;

final class BuildProperties implements JsonSerializable
{
    private $properties = [];

    public function __construct($key, $value = null)
    {
        $this->properties = is_array($key) ? $key : [$key => $value];
    }

    public function addProperty(string $key, string $value) {
        $this->properties[$key] = $value;
    }

    public function toArray()
    {
        return ['properties' => $this->properties];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}