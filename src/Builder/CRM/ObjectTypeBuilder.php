<?php


namespace Hubspot\Psr7\Builder\CRM;


use Ds\Map;
use Ds\Set;

class ObjectTypeBuilder implements ObjectTypeInterface
{
    const PROPERTY_CURRENCY = "CURRENCY";
    const PROPERTY_DATE = "DATE";
    const PROPERTY_DATETIME = "DATETIME";
    const PROPERTY_EMAIL = "EMAIL";
    const PROPERTY_LINK = "LINK";
    const PROPERTY_NUMERIC = "NUMERIC";
    const PROPERTY_STATUS = "STATUS";
    const PROPERTY_STRING = "STRING";
    const STATUS_DEFAULT = "DEFAULT";
    const STATUS_SUCCESS = "SUCCESS";
    const STATUS_WARNING = "WARNING";
    const STATUS_DANGER = "DANGER";
    const STATUS_INFO = "INFO";
    const OBJECT_CONTACT = "CONTACT";
    const OBJECT_COMPANY = "COMPANY";
    const OBJECT_DEAL = "DEAL";
    const OBJECT_TICKET = "TICKET";

    private $objectType;
    private $properties;
    private $dataFetchProperties;

    public function __construct(string $title, int $applicationId, array $baseUris, string $dataFetchUri)
    {
        $this->objectType = new Map([
            'title' => $title,
            'applicationId' => $applicationId,
            'baseUris' => $baseUris,
            'dataFetchUri' => $dataFetchUri,
        ]);

        $this->properties = new Set();
        $this->dataFetchProperties = new Map();
    }

    public function addProperty(string $type, string $name, string $label) {
        $property = new Map([
            'label' => $label,
            'name' => $name,
            'dataType' => $type
        ]);
        $this->properties->add($property);

        return $this;
    }

    public function addStatusProperty(string $name, string $label, array $options) {
        $property = new Map([
            'label' => $label,
            'name' => $name,
            'dataType' => self::PROPERTY_STATUS,
            'options' => $options
        ]);
        $this->properties->add($property);

        return $this;
    }

    public static function createStatusOption(string $name, string $label, string $type = self::STATUS_DEFAULT)
    {
        return [
            'type' => $type,
            'label' => $label,
            'name' => $name
        ];
    }

    public function addDataFetchObjectProperty(string $object, string $property)
    {
        if($this->dataFetchProperties->hasKey($object)) {
            $this->dataFetchProperties[$object][] = $property;
        } else {
            $this->dataFetchProperties->put($object, [$property]);
        }

        return $this;
    }

    public function getObjectType()
    {
        if($this->properties->count() > 0) {
            $this->objectType->put('propertyDefinitions', $this->properties);
        }

        if($this->dataFetchProperties->count() > 0) {
            $this->objectType->put('associatedHubSpotObjectTypeProperties', $this->dataFetchProperties);
        }

        return $this->objectType;
    }
}