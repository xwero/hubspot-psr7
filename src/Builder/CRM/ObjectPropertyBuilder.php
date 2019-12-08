<?php


namespace Hubspot\Psr7\Builder\CRM;


use Ds\Map;
use Ds\Set;

class ObjectPropertyBuilder implements ObjectPropertyInterface
{
    const PROPERTY_STRING = 'string';
    const PROPERTY_NUMBER = 'number';
    const PROPERTY_DATE = 'date';
    const PROPERTY_DATE_TIME = 'datetime';
    const PROPERTY_ENUMERATION = 'enumeration';
    const FIELD_TEXTAREA = 'textarea';
    const FIELD_TEXT = 'text';
    const FIELD_DATE = 'date';
    const FIELD_FILE = 'file';
    const FIELD_NUMBER = 'number';
    const FIELD_SELECT = 'select';
    const FIELD_RADIO = 'radio';
    const FIELD_CHECKBOX = 'checkbox';
    const FIELD_BOOLEAN = 'booleancheckbox';

    private $objectProperty;
    private $options;

    public function __construct(string $name)
    {
        $this->objectProperty = new Map(['name' => $name]);
        $this->options = new Set();
    }

    public function setLabel(string $label)
    {
        $this->objectProperty['label'] = $label;

        return $this;
    }

    public function setDescription(string $description)
    {
        $this->objectProperty['description'] = $description;

        return $this;
    }

    public function setGroup(string $group)
    {
        $this->objectProperty['groupName'] = $group;

        return $this;
    }

    public function setPropertyType(string $type)
    {
        if(in_array($type, [self::PROPERTY_DATE, self::PROPERTY_DATE_TIME, self::PROPERTY_ENUMERATION, self::PROPERTY_NUMBER, self::PROPERTY_STRING])) {
            $this->objectProperty['type'] = $type;
        }

        return $this;
    }

    public function setFieldType(string $type)
    {
        if(in_array($type, [self::FIELD_BOOLEAN, self::FIELD_CHECKBOX, self::FIELD_DATE, self::FIELD_FILE, self::FIELD_NUMBER, self::FIELD_RADIO, self::FIELD_SELECT, self::FIELD_TEXT, self::FIELD_TEXTAREA])) {
            $this->objectProperty['fieldType'] = $type;
        }

        return $this;
    }

    public function addFieldOption($value, $label, $description = '')
    {
        $option = new Map([
            'value' => $value,
            'label' => $label,
            'displayOrder' => $this->options->count(),
        ]);

        if(strlen($description) > 0) {
            $option['description'] = $description;
        }

        $this->options->add($option);

        return $this;
    }

    public function setOrder(int $order)
    {
        $this->objectProperty['displayOrder'] = $order;

        return $this;
    }

    public function getObjectProperty()
    {
        if(count($this->options) > 0) {
            $this->objectProperty['options'] = $this->options;
        }

        return $this->objectProperty;
    }
}