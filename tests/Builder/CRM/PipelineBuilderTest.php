<?php

namespace Builder\CRM;

use Hubspot\Psr7\Builder\CRM\PipelineBuilder;
use PHPUnit\Framework\TestCase;

class PipelineBuilderTest extends TestCase
{

    public function testAddStage()
    {
        $pipeline = (new PipelineBuilder(1, 'pipeline', 1))
                        ->addStage(2, 'stage', true);
        $expected = '{"pipelineId":"1","label":"pipeline","displayOrder":1,"active":true,"stages":[{"stageId":"2","label":"stage","active":true,"displayOrder":0,"createdAt":"';

        $this->assertStringContainsString($expected, json_encode($pipeline->getPipeline()));
    }

    public function testSetTicketState()
    {
        $pipeline = (new PipelineBuilder(1, 'pipeline', 1))
            ->setTicketState();
        $expected = '{"pipelineId":"1","label":"pipeline","displayOrder":1,"active":true,"metadata":{"ticketState":true}}';

        $this->assertSame($expected, json_encode($pipeline->getPipeline()));
    }

    public function testSetDealProbability()
    {
        $pipeline = (new PipelineBuilder(1, 'pipeline', 1))
            ->setDealProbability(0.1);
        $expected = '{"pipelineId":"1","label":"pipeline","displayOrder":1,"active":true,"metadata":{"probability":0.1}}';

        $this->assertSame($expected, json_encode($pipeline->getPipeline()));
    }
}
