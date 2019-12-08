<?php


namespace Hubspot\Psr7\Builder\CRM;


use Ds\Map;
use Ds\Set;

class PipelineBuilder implements PipelineInterface
{
    private $pipeline;
    private $stages;

    public function __construct(string $id, string $label, int $order, bool $active = true)
    {
        $this->stages = new Set();
        $this->pipeline = new Map([
            'pipelineId' => $id,
            'label' => $label,
            'displayOrder' => $order,
            'active' => $active
        ]);
    }

    public function addStage(string $id, string $label, bool $new, $active = true) {
        $stage = new Map([
           'stageId' => $id,
            'label' => $label,
            'active' => $active,
            'displayOrder' => $this->stages->count(),
        ]);

        if($new) {
            $stage['createdAt'] = microtime(false);
        } else {
            $stage['updatedAt'] = microtime(false);
        }

        $this->stages->add($stage);

        return $this;
    }

    public function setDealProbability(float $probability)
    {
        if($probability > 0 && $probability <= 1) {
            if($this->pipeline->hasKey('metadata')) {
                $this->pipeline["metadata"]["probability"] = $probability;
            } else {
                $this->pipeline->put('metadata', ["probability" => $probability]);
            }
        }

        return $this;
    }

    public function setTicketState(bool $isOpen = true) {
        if($this->pipeline->hasKey('metadata')) {
            $this->pipeline["metadata"]["ticketState"] = $isOpen;
        } else {
            $this->pipeline->put('metadata', ["ticketState" => $isOpen]);
        }

        return $this;
    }

    public function getPipeline()
    {
        if($this->stages->count() > 0) {
            $this->pipeline['stages'] = $this->stages;
        }

        return $this->pipeline;
    }
}