<?php


namespace Hubspot\Psr7\Request\CRM;


use Ds\Map;
use Ds\Set;
use Hubspot\Psr7\Builder\AssociationQueryStringBuilder;
use Hubspot\Psr7\Builder\EndpointBuilder;
use Hubspot\Psr7\Exception\AssiociationException;
use Hubspot\Psr7\Request\Base;

final class AssociationsRequest extends Base
{
    const TYPE_ADVISOR = 'advisor';
    const TYPE_BOARD_MEMBER= 'board member';
    const TYPE_BUSINESS_OWNER = 'business owner';
    const TYPE_CHILD_COMPANY  = 'child company';
    const TYPE_COMPANY = 'company';
    const TYPE_CONTACT = 'contact';
    const TYPE_CONTRACTOR = 'contractor';
    const TYPE_DEAL = 'deal';
    const TYPE_ENGAGEMENT = 'engagement';
    const TYPE_LINE_ITEM = 'line item';
    const TYPE_MANAGER = 'manager';
    const TYPE_PARENT_COMPANY = 'parent company';
    const TYPE_PARTNER = 'partner';
    const TYPE_RESELLER = 'reseller';
    const TYPE_TICKET = 'ticket';

    public function getAssociation($from, int $fromId, $to, int $limit = 10, int $offset = 0)
    {
        $associationId = $this->getAssociationId($from, $to);
        $endpoint = new EndpointBuilder('/crm-associations/:apiversion/associations/:objectId/HUBSPOT_DEFINED/:definitionId', $this->authorisation);

        $endpoint->setReplacements([':objectId' => $fromId, ':definitionId' => $associationId]);

        if ($limit !== 10 || $offset > 0) {
            $queryString = new AssociationQueryStringBuilder();

            if($limit !== 10) {
                $queryString->setLimit($limit);
            }

            if($offset > 0) {
                $queryString->setOffset($offset);
            }

            $endpoint->setQueryString($queryString);
        }

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function createAssociation($from, int $fromId, $to, int $toId)
    {
        $endpoint = new EndpointBuilder('/crm-associations/:apiversion/associations', $this->authorisation);
        $body = $this->buildAssociationBody($from, $to, $fromId, $toId);

        return $this->buildRequest(self::METHOD_PUT, $endpoint->getEndpoint(), $body);
    }

    public function createAssociations($from, array $fromIds, $to, array $toIds)
    {
        $endpoint = new EndpointBuilder('/crm-associations/:apiversion/associations/create-batch', $this->authorisation);
        $body = $this->buildAssociationBody($from, $to, $fromIds, $toIds);

        return $this->buildRequest(self::METHOD_PUT, $endpoint->getEndpoint(), $body);
    }

    public function deleteAssociation($from, int $fromId, $to, int $toId)
    {
        $endpoint = new EndpointBuilder('/crm-associations/:apiversion/associations/delete', $this->authorisation);
        $body = $this->buildAssociationBody($from, $to, $fromId, $toId);

        return $this->buildRequest(self::METHOD_PUT, $endpoint->getEndpoint(), $body);
    }

    public function deleteAssociations($from, array $fromIds, $to, array $toIds)
    {
        $endpoint = new EndpointBuilder('/crm-associations/:apiversion/associations/delete-batch', $this->authorisation);
        $body = $this->buildAssociationBody($from, $to, $fromIds, $toIds);

        return $this->buildRequest(self::METHOD_PUT, $endpoint->getEndpoint(), $body);
    }

    private function getAssociationId($from, $to)
    {
        $associationIds = [
            self::TYPE_ADVISOR => [
                self::TYPE_COMPANY => 33,
            ],
            self::TYPE_BOARD_MEMBER => [
                self::TYPE_COMPANY => 35,
            ],
            self::TYPE_BUSINESS_OWNER => [
                self::TYPE_COMPANY => 41,
            ],
            self::TYPE_CHILD_COMPANY => [
                self::TYPE_PARENT_COMPANY => 14,
            ],
            self::TYPE_COMPANY => [
                self::TYPE_ADVISOR => 34,
                self::TYPE_BOARD_MEMBER => 36,
                self::TYPE_BUSINESS_OWNER => 42,
                self::TYPE_CONTACT => 2,
                self::TYPE_CONTRACTOR => 38,
                self::TYPE_DEAL => 6,
                self::TYPE_ENGAGEMENT => 7,
                self::TYPE_MANAGER => 40,
                self::TYPE_PARTNER => 44,
                self::TYPE_RESELLER => 46,
                self::TYPE_TICKET => 25
            ],
            self::TYPE_CONTACT => [
                self::TYPE_COMPANY => 1,
                self::TYPE_DEAL => 4,
                self::TYPE_ENGAGEMENT => 9,
                self::TYPE_TICKET => 15,
            ],
            self::TYPE_CONTRACTOR => [
                self::TYPE_COMPANY => 37,
            ],
            self::TYPE_DEAL => [
                self::TYPE_COMPANY => 5,
                self::TYPE_ENGAGEMENT => 11,
                self::TYPE_LINE_ITEM => 19,
                self::TYPE_TICKET => 27,
            ],
            self::TYPE_ENGAGEMENT => [
                self::TYPE_COMPANY => 8,
                self::TYPE_CONTACT => 10,
                self::TYPE_DEAL => 12,
                self::TYPE_TICKET => 18,
            ],
            self::TYPE_LINE_ITEM => [
                self::TYPE_DEAL => 20,
            ],
            self::TYPE_MANAGER => [
                self::TYPE_COMPANY => 39,
            ],
            self::TYPE_PARENT_COMPANY => [
                self::TYPE_CHILD_COMPANY => 13
            ],
            self::TYPE_PARTNER => [
                self::TYPE_COMPANY => 43,
            ],
            self::TYPE_RESELLER => [
                self::TYPE_COMPANY => 45,
            ],
            self::TYPE_TICKET => [
                self::TYPE_COMPANY => 26,
                self::TYPE_CONTACT => 16,
                self::TYPE_DEAL => 28,
                self::TYPE_ENGAGEMENT => 17,
            ]
        ];

        if(!isset($associationIds[$from][$to])) {
            throw new AssiociationException("The association $from to $to does not exist.");
        }
    }

    private function buildAssociationBody($from, $to, $fromId, $toId)
    {
        $associationId = $this->getAssociationId($from, $to);
        $associations = new Set();

        if(is_int($fromId)) {
            $fromId = [$fromId];
            $toId = [$toId];
        }

        for($i=0, $max=count($fromId); $i < $max; $i++){
            $association = new Map([
                "fromObjectId" => $fromId[$i],
                "toObjectId" => $toId[$i],
                "category" => "HUBSPOT_DEFINED",
                "definitionId" => $associationId
            ]);

            $associations->add($association);
        }

        return $associations->count() === 1 ? $associations->get(0) : $associations ;
    }
}