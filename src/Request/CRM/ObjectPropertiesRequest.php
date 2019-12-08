<?php


namespace Hubspot\Psr7\Request\CRM;


use Hubspot\Psr7\Builder\EndpointBuilder;
use Hubspot\Psr7\Builder\ObjectPropertyInterface;
use Hubspot\Psr7\Builder\ObjectTypeInterface;
use Hubspot\Psr7\Exception\BadObjectTypeException;
use Hubspot\Psr7\Request\Base;

class ObjectPropertiesRequest extends Base
{
    const OBJECT_TICKET = 'tickets';
    const OBJECT_PRODUCT = 'products';
    const OBJECT_LINE_ITEM = 'line_items';

    public function getAllForObjectType(string $objectType)
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/properties/:apiversion/:object_type/properties', $this->authorisation);

        $endpoint->setVersion2();
        $endpoint->setReplacements([':object_type' => $objectType]);

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function createPropertyForObjectType(string $objectType, ObjectPropertyInterface $objectProperty)
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/properties/:apiversion/:object_type/properties', $this->authorisation);

        $endpoint->setVersion2();
        $endpoint->setReplacements([':object_type' => $objectType]);

        return $this->buildRequest(self::METHOD_POST, $endpoint->getEndpoint(), $objectProperty->getObjectProperty());
    }

    public function updatePropertyForObjectType(string $objectType, ObjectPropertyInterface $objectProperty, string $propertyName)
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/properties/:apiversion/:object_type/properties/named/:property', $this->authorisation);

        $endpoint->setVersion2();
        $endpoint->setReplacements([':object_type' => $objectType, ':property' => $propertyName]);

        return $this->buildRequest(self::METHOD_PATCH, $endpoint->getEndpoint(), $objectProperty->getObjectProperty());
    }

    public function deletePropertyForObjectType(string $objectType, string $propertyName)
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/properties/:apiversion/:object_type/properties/named/:property', $this->authorisation);

        $endpoint->setVersion2();
        $endpoint->setReplacements([':object_type' => $objectType, ':property' => $propertyName]);

        return $this->buildRequest(self::METHOD_DELETE, $endpoint->getEndpoint());
    }

    public function getAllPropertyGroupsForObjectType(string $objectType)
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/properties/:apiversion/:object_type/groups', $this->authorisation);

        $endpoint->setVersion2();
        $endpoint->setReplacements([':object_type' => $objectType]);

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function createPropertyGroupForObjectType(string $objectType, string $name, string $label)
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/properties/:apiversion/:object_type/groups', $this->authorisation);

        $endpoint->setVersion2();
        $endpoint->setReplacements([':object_type' => $objectType]);

        return $this->buildRequest(self::METHOD_POST, $endpoint->getEndpoint(), $this->buildGroup($name, $label));
    }

    public function updatePropertyGroupForObjectType(string $objectType, string $oldName, string $label, string $newName = '')
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/properties/:apiversion/:object_type/groups/named/:group', $this->authorisation);

        $endpoint->setVersion2();
        $endpoint->setReplacements([':object_type' => $objectType, ':group' => $oldName]);

        $body = $this->buildGroup(empty($newName) ? $oldName : $newName, $label);

        return $this->buildRequest(self::METHOD_PUT, $endpoint->getEndpoint(), $body);
    }

    public function deletePropertyGroupForObjectType(string $objectType, string $name)
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/properties/:apiversion/:object_type/groups/named/:group', $this->authorisation);

        $endpoint->setVersion2();
        $endpoint->setReplacements([':object_type' => $objectType, ':group' => $name]);

        return $this->buildRequest(self::METHOD_DELETE, $endpoint->getEndpoint());
    }

    private function buildGroup($name, $label) {
        return [
            'name' => $name,
            'displayName' => $label
        ];
    }

    private function checkObjectType($objectType)
    {
        if(!in_array($objectType, [self::OBJECT_LINE_ITEM, self::OBJECT_TICKET, self::OBJECT_PRODUCT])) {
            throw new BadObjectTypeException($objectType.' is not allowed in '.__CLASS__);
        }
    }
}