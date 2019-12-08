<?php

namespace Builder\CRM;

use Hubspot\Psr7\Builder\CRM\AssociationQueryStringBuilder;
use PHPUnit\Framework\TestCase;

class AssociationQueryStringBuilderTest extends TestCase
{

    public function testSetLimit()
    {
        $qs = (new AssociationQueryStringBuilder())
            ->setLimit(1);

        $this->assertSame('limit=1', $qs->getQueryString());
    }

    public function testSetOffset()
    {
        $qs = (new AssociationQueryStringBuilder())
            ->setOffset(1);

        $this->assertSame('offset=1', $qs->getQueryString());
    }

    public function testMultipleOptions()
    {
        $qs = (new AssociationQueryStringBuilder())
            ->setLimit(1)
            ->setOffset(1);

        $this->assertSame('offset=1&limit=1', $qs->getQueryString());
    }
}
