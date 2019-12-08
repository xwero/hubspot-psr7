<?php


namespace Hubspot\Psr7\Request\CRM;


use Hubspot\Psr7\Builder\EndpointBuilder;
use Hubspot\Psr7\Builder\PipelineInterface;
use Hubspot\Psr7\Builder\PipelineQueryStringBuilder;
use Hubspot\Psr7\Builder\QueryStringInterface;
use Hubspot\Psr7\Exception\BadObjectTypeException;
use Hubspot\Psr7\Request\Base;

class PipelinesRequest extends Base
{
    const OBJECT_TICKET = 'tickets';
    const OBJECT_DEAL = 'deals';

    public function getAllPipelinesForObjectType($objectType, $includeDeleted = false)
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/crm-pipelines/:apiversion/pipelines/:object_type', $this->authorisation);

        $endpoint->setReplacements([':object_type' => $objectType]);

        if($includeDeleted) {
            $queryString = (new PipelineQueryStringBuilder())->includeDeleted();

            $endpoint->setQueryString($queryString);
        }

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function createPipelineForObjectType(string $objectType, PipelineInterface $pipeline)
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/crm-pipelines/:apiversion/pipelines/:object_type', $this->authorisation);

        $endpoint->setReplacements([':object_type' => $objectType]);

        return $this->buildRequest(self::METHOD_POST, $endpoint->getEndpoint(), $pipeline);
    }

    public function updatePipelineForObjectType(string $objectType, int $pipelineId, PipelineInterface $pipeline)
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/crm-pipelines/:apiversion/pipelines/:object_type/:id', $this->authorisation);

        $endpoint->setReplacements([':object_type' => $objectType, ':id' => $pipelineId]);

        return $this->buildRequest(self::METHOD_POST, $endpoint->getEndpoint(), $pipeline->getPipeline());
    }

    public function deletePipelineForObjectType(string $objectType, int $pipelineId)
    {
        $this->checkObjectType($objectType);

        $endpoint = new EndpointBuilder('/crm-pipelines/:apiversion/pipelines/:object_type/:id', $this->authorisation);

        $endpoint->setReplacements([':object_type' => $objectType, ':id' => $pipelineId]);

        return $this->buildRequest(self::METHOD_DELETE, $endpoint->getEndpoint());
    }

    private function checkObjectType($objectType)
    {
        if(!in_array($objectType, [self::OBJECT_DEAL, self::OBJECT_TICKET])) {
            throw new BadObjectTypeException($objectType.' is not allowed in '.__CLASS__);
        }
    }
}