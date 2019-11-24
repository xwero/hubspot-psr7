<?php


namespace Hubspot\Psr7\Builder;


use JsonSerializable;

final class PropertiesBuilder implements JsonSerializable
{
    private $properties = [];

    public function __construct($key, $value = null)
    {
        if(!is_null($value)) {
            $this->properties = [['property' => $key, 'value' => $value]];

            return $this;
        }

        $testKey = array_keys($key)[0];

        if(is_int($testKey)) {
            foreach ($key as $pair){
                $property = array_keys($pair)[0];
                $this->properties[] = [
                    'property' => $property,
                    'value' => $pair[$property]
                ];
            }

            return $this;
        }

        foreach ($key as $property => $value) {
            $this->properties[] = [
                'property' => $property,
                'value' => $value
            ];
        }

        return $this;
    }

    public function addProperty(string $key, string $value) {
        $this->properties[] = ['property' => $key, 'value' => $value];
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