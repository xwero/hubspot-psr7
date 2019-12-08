<?php

namespace Builder\CRM;

use Hubspot\Psr7\Builder\CRM\PipelineQueryStringBuilder;
use PHPUnit\Framework\TestCase;

class PipelineQueryStringBuilderTest extends TestCase
{

    public function testIncludeDeleted()
    {
        $qs = (new PipelineQueryStringBuilder())
                ->includeDeleted();

        $this->assertSame('includeInactive=INCLUDE_DELETED', $qs->getQueryString());
    }
}
