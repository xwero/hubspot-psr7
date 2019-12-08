<?php

namespace Builder\CRM;

use Hubspot\Psr7\Builder\CRM\ObjectTypeBuilder;
use PHPUnit\Framework\TestCase;

class ObjectTypeBuilderTest extends TestCase
{

    public function testCreateStatusOption()
    {
        $so = ObjectTypeBuilder::createStatusOption('status', 'Status');

        $this->assertSame('{"type":"DEFAULT","label":"Status","name":"status"}', json_encode($so));

        $so2 = ObjectTypeBuilder::createStatusOption('status', 'Status', ObjectTypeBuilder::STATUS_DANGER);

        $this->assertSame('{"type":"DANGER","label":"Status","name":"status"}', json_encode($so2));
    }

    public function testAddStatusProperty()
    {
        $so = ObjectTypeBuilder::createStatusOption('status', 'Status');
        $ot = (new ObjectTypeBuilder('object', 1, ['https://example.com/actions'], 'https://example.com/object'))
                ->addStatusProperty('status_property', 'Status property', [$so]);
        $expected = '{"title":"object","applicationId":1,"baseUris":["https:\/\/example.com\/actions"],"dataFetchUri":"https:\/\/example.com\/object","propertyDefinitions":[{"label":"Status property","name":"status_property","dataType":"STATUS","options":[{"type":"DEFAULT","label":"Status","name":"status"}]}]}';

        $this->assertSame($expected, json_encode($ot->getObjectType()));
    }

    public function testAddProperty()
    {
        $ot = (new ObjectTypeBuilder('object', 1, ['https://example.com/actions'], 'https://example.com/object'))
            ->addProperty(ObjectTypeBuilder::PROPERTY_STRING, 'string', 'String');
        $expected = '{"title":"object","applicationId":1,"baseUris":["https:\/\/example.com\/actions"],"dataFetchUri":"https:\/\/example.com\/object","propertyDefinitions":[{"label":"String","name":"string","dataType":"STRING"}]}';

        $this->assertSame($expected, json_encode($ot->getObjectType()));
    }

    public function testAddDataFetchObjectProperty()
    {
        $ot = (new ObjectTypeBuilder('object', 1, ['https://example.com/actions'], 'https://example.com/object'))
            ->addDataFetchObjectProperty(ObjectTypeBuilder::OBJECT_TICKET, 'field');
        $expected = '{"title":"object","applicationId":1,"baseUris":["https:\/\/example.com\/actions"],"dataFetchUri":"https:\/\/example.com\/object","associatedHubSpotObjectTypeProperties":{"TICKET":["field"]}}';

        $this->assertSame($expected, json_encode($ot->getObjectType()));
    }
}
