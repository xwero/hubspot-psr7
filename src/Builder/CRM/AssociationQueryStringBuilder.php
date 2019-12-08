<?php


namespace Hubspot\Psr7\Builder\CRM;


use Ds\Vector;
use Hubspot\Psr7\Builder\BaseQueryStringBuilder;

class AssociationQueryStringBuilder extends BaseQueryStringBuilder
{
    const OPTION_LIMIT = 1;

    public function setLimit(int $limit)
    {
        $this->keyValuePairs->put(self::OPTION_LIMIT, $limit);

        return $this;
    }

    public function getQueryString()
    {
        $queryStringCollection = new Vector();

        if($this->keyValuePairs->hasKey(self::OPTION_OFFSET)) {
            $queryStringCollection[] = 'offset=' . $this->keyValuePairs[self::OPTION_OFFSET];
        }

        if($this->keyValuePairs->hasKey(self::OPTION_LIMIT)) {
            $queryStringCollection[] = 'limit=' . $this->keyValuePairs[self::OPTION_LIMIT];
        }

        return $queryStringCollection->isEmpty() ? '' : $queryStringCollection->join('&');
    }
}