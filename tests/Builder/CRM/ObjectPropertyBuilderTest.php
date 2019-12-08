<?php

namespace Builder\CRM;

use Hubspot\Psr7\Builder\CRM\ObjectPropertyBuilder;
use PHPUnit\Framework\TestCase;

class ObjectPropertyBuilderTest extends TestCase
{

    public function testSetPropertyType()
    {
        $op = (new ObjectPropertyBuilder('test'))
                ->setPropertyType(ObjectPropertyBuilder::PROPERTY_STRING);

        $this->assertSame('{"name":"test","type":"string"}', json_encode($op->getObjectProperty()));
    }

    public function testSetOrder()
    {
        $op = (new ObjectPropertyBuilder('test'))
            ->setOrder(1);

        $this->assertSame('{"name":"test","displayOrder":1}', json_encode($op->getObjectProperty()));
    }

    public function testSetGroup()
    {
        $op = (new ObjectPropertyBuilder('test'))
            ->setGroup('group');

        $this->assertSame('{"name":"test","groupName":"group"}', json_encode($op->getObjectProperty()));
    }

    public function testAddFieldOption()
    {
        $op = (new ObjectPropertyBuilder('test'))
            ->addFieldOption(1, 'option');

        $this->assertSame('{"name":"test","options":[{"value":1,"label":"option","displayOrder":0}]}', json_encode($op->getObjectProperty()));
    }

    public function testSetFieldType()
    {
        $op = (new ObjectPropertyBuilder('test'))
            ->setFieldType(ObjectPropertyBuilder::FIELD_TEXTAREA);

        $this->assertSame('{"name":"test","fieldType":"textarea"}', json_encode($op->getObjectProperty()));
    }

    public function testSetLabel()
    {
        $op = (new ObjectPropertyBuilder('test'))
            ->setLabel('label');

        $this->assertSame('{"name":"test","label":"label"}', json_encode($op->getObjectProperty()));
    }

    public function testSetDescription()
    {
        $op = (new ObjectPropertyBuilder('test'))
            ->setDescription('description');

        $this->assertSame('{"name":"test","description":"description"}', json_encode($op->getObjectProperty()));
    }

    public function testCompleteOption()
    {
        $op = (new ObjectPropertyBuilder('pets'))
                ->setLabel('Pets')
                ->setPropertyType(ObjectPropertyBuilder::PROPERTY_ENUMERATION)
                ->setFieldType(ObjectPropertyBuilder::FIELD_SELECT)
                ->addFieldOption('dog', 'Dog')
                ->addFieldOption('cat', 'Cat');

        $this->assertSame('{"name":"pets","label":"Pets","type":"enumeration","fieldType":"select","options":[{"value":"dog","label":"Dog","displayOrder":0},{"value":"cat","label":"Cat","displayOrder":1}]}', json_encode($op->getObjectProperty()));
    }
}
