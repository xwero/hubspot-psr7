<?php

use Hubspot\Psr7\Builder\PropertiesBuilder;
use PHPUnit\Framework\TestCase;

class PropertiesBuilderTest extends TestCase
{

    public function testOnePropertyByKeyValue()
    {
        $props = new PropertiesBuilder('a', 'b');
        $json = json_encode($props);

        $this->assertSame('{"properties":[{"property":"a","value":"b"}]}', $json);
    }

    public function testOnePropertyByArray()
    {
        $props = new PropertiesBuilder(['a' => 'b']);
        $json = json_encode($props);

        $this->assertSame('{"properties":[{"property":"a","value":"b"}]}', $json);
    }

    public function testTwoProperties()
    {
        $props = new PropertiesBuilder([['a' => 'b'],['c' => 'd']]);
        $props2 = new PropertiesBuilder('a', 'b');

        $props2->addProperty('c', 'd');

        $expected = '{"properties":[{"property":"a","value":"b"},{"property":"c","value":"d"}]}';

        $this->assertSame($expected, json_encode($props));
        $this->assertSame($expected, json_encode($props2));
    }
}
