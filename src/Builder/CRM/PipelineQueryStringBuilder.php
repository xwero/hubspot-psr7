<?php


namespace Hubspot\Psr7\Builder\CRM;


use Hubspot\Psr7\Builder\BaseQueryStringBuilder;

class PipelineQueryStringBuilder extends BaseQueryStringBuilder
{
    private $includeDeleted = false;

    public function includeDeleted() {
        $this->includeDeleted = true;

        return $this;
    }

    public function getQueryString()
    {
        return $this->includeDeleted ? 'includeInactive=INCLUDE_DELETED' : '';
    }
}