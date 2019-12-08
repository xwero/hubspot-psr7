<?php


namespace Hubspot\Psr7\Request\CRM;


use Hubspot\Psr7\Builder\EndpointBuilder;
use Hubspot\Psr7\Builder\ObjectTypeInterface;
use Hubspot\Psr7\Request\Base;

class ExtensionsRequest extends Base
{
    public function createObjectType(ObjectTypeInterface $objectType)
    {
        $endpoint = new EndpointBuilder(' /extensions/sales-objects/:apiversion/object-types', $this->authorisation);

        return $this->buildRequest(self::METHOD_POST, $endpoint->getEndpoint(), $objectType->getObjectType());
    }

    public function viewObjectType(int $id)
    {
        $endpoint = new EndpointBuilder('/extensions/sales-objects/:apiversion/object-types/:id', $this->authorisation);

        $endpoint->setReplacements([':id' => $id]);

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function updateObjectType(int $id, ObjectTypeInterface $objectType)
    {
        $endpoint = new EndpointBuilder('/extensions/sales-objects/:apiversion/object-types/:id', $this->authorisation);

        $endpoint->setReplacements([':id' => $id]);

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint(), $objectType->getObjectType());
    }

    public function deleteObjectType(int $id)
    {
        $endpoint = new EndpointBuilder('/extensions/sales-objects/:apiversion/object-types/:id', $this->authorisation);

        $endpoint->setReplacements([':id' => $id]);

        return $this->buildRequest(self::METHOD_DELETE, $endpoint->getEndpoint());
    }
}