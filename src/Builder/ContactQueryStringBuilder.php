<?php

namespace Hubspot\Psr7\Builder;


use Ds\Map;
use Ds\Set;
use Ds\Vector;
use Hubspot\Psr7\Exception\RequiredQueryStringOptionsException;

class ContactQueryStringBuilder extends BaseQueryStringBuilder
{
    const PROPERTY_MODE_FULL = 'value_and_history';
    const SUBMISSION_MODE_ALL = 'all';
    const SUBMISSION_MODE_NONE = 'none';
    const SUBMISSION_MODE_OLDEST = 'oldest';
    const ORDER_ASC = 'ASC';
    const OPTION_PROPERTIES = 0;
    const OPTION_IDS = 1;
    const OPTION_TOKENS = 2;
    const OPTION_COUNT = 3;
    const OPTION_PROPERTY_MODE = 4;
    const OPTION_SHOW_LIST_MEMBERSHIP = 5;
    const OPTION_SHOW_DELETED = 6;
    const OPTION_ORDER_ASCENDING = 7;
    const OPTION_FORM_SUBMISSION_MODE = 8;
    const OPTION_ID_OFFSET = 9;
    const OPTION_TIME_OFFSET = 10;
    const OPTION_SEARCH = 11;
    const OPTION_SORT = 12;
    const OPTION_TIMESTAMP_FROM = 13;
    const OPTION_TIMESTAMP_TO = 14;
    const OPTION_AGGREGATION = 15;

    public function addProperty(string $property)
    {
        $properties = $this->keyValuePairs->get(self::OPTION_PROPERTIES, new Vector());

        $properties->push($property);

        $this->keyValuePairs->put(self::OPTION_PROPERTIES, $properties);

        return $this;
    }

    public function addProperties(array $properties)
    {
        $this->keyValuePairs->put(self::OPTION_PROPERTIES, new Vector($properties));

        return $this;
    }

    public function addId(int $id)
    {
        $ids = $this->keyValuePairs->get(self::OPTION_IDS, new Vector());

        $ids->push($id);

        $this->keyValuePairs->put(self::OPTION_IDS, $ids);

        return $this;
    }

    public function addIds(array $ids)
    {
        $this->keyValuePairs->put(self::OPTION_IDS, new Vector($ids));

        return $this;
    }

    public function addToken(string $token)
    {
        $tokens = $this->keyValuePairs->get(self::OPTION_TOKENS, new Vector());

        $tokens->push($token);

        $this->keyValuePairs->put(self::OPTION_TOKENS, $tokens);

        return $this;
    }

    public function addTokens(array $tokens)
    {
        $this->keyValuePairs->put(self::OPTION_TOKENS, new Vector($tokens));

        return $this;
    }

    public function setCount(int $count)
    {
        $this->keyValuePairs->put(self::OPTION_COUNT, $count);

        return $this;
    }

    public function setFullPropertyMode()
    {
        $this->keyValuePairs->put(self::OPTION_PROPERTY_MODE, self::PROPERTY_MODE_FULL);

        return $this;
    }

    public function showListMembership()
    {
        $this->keyValuePairs->put(self::OPTION_SHOW_LIST_MEMBERSHIP, TRUE);

        return $this;
    }

    public function includeDeleted()
    {
        $this->keyValuePairs->put(self::OPTION_SHOW_DELETED, TRUE);

        return $this;
    }

    public function orderAscending()
    {
        $this->keyValuePairs->put(self::OPTION_ORDER_ASCENDING, self::ORDER_ASC);

        return $this;
    }

    public function setFormSubmissionMode(string $submissionMode)
    {
        if(in_array($submissionMode, [self::SUBMISSION_MODE_ALL, self::SUBMISSION_MODE_OLDEST, self::SUBMISSION_MODE_NONE])) {
            $this->keyValuePairs->put(self::OPTION_FORM_SUBMISSION_MODE, $submissionMode);
        }

        return $this;
    }

    public function setIdOffset(int $id)
    {
        $this->keyValuePairs->put(self::OPTION_ID_OFFSET, $id);

        return $this;
    }

    public function setTimeOffset(int $time)
    {
        $this->keyValuePairs->put(self::OPTION_TIME_OFFSET, $time);

        return $this;
    }

    public function setSearch(string $search)
    {
        $this->keyValuePairs->put(self::OPTION_SEARCH, $search);

        return $this;
    }

    /**
     * @param string $sort a property internal name
     * @return $this
     */
    public function setSort(string $sort)
    {
        $this->keyValuePairs->put(self::OPTION_SORT, $sort);

        return $this;
    }

    public function setFromTimestamp(int $timestamp)
    {
        $this->keyValuePairs->put(self::OPTION_TIMESTAMP_FROM, $timestamp);

        return $this;
    }

    public function setToTimestamp(int $timestamp)
    {
        $this->keyValuePairs->put(self::OPTION_TIMESTAMP_TO, $timestamp);

        return $this;
    }

    public function setAggregationProperty(string $property)
    {
        $this->keyValuePairs->put(self::OPTION_AGGREGATION, $property);

        return $this;
    }

    public function getQueryString()
    {
        $queryStringCollection = new Vector();

        if($this->keyValuePairs->hasKey(self::OPTION_PROPERTIES)) {
            $queryStringCollection[] = 'property=' . $this->keyValuePairs[self::OPTION_PROPERTIES]->join('&property=');
        }

        if($this->keyValuePairs->hasKey(self::OPTION_IDS)) {
            $queryStringCollection[] = 'vid=' . $this->keyValuePairs[self::OPTION_IDS]->join('&vid=');
        }

        if($this->keyValuePairs->hasKey(self::OPTION_TOKENS)) {
            $queryStringCollection[] = 'utk=' . $this->keyValuePairs[self::OPTION_TOKENS]->join('&utk=');
        }

        if($this->keyValuePairs->hasKey(self::OPTION_COUNT) && $this->keyValuePairs[self::OPTION_COUNT] !== 20) {
            $queryString = 'count=';
            $count = $this->keyValuePairs[self::OPTION_COUNT];
            $queryString .= $count > 100 ? 100 : $count;

            $queryStringCollection[] = $queryString;
        }

        if($this->keyValuePairs->hasKey(self::OPTION_OFFSET)) {
            $queryStringCollection[] = 'offset=' . $this->keyValuePairs[self::OPTION_OFFSET];
        }

        if($this->keyValuePairs->hasKey(self::OPTION_ID_OFFSET)) {
            $queryStringCollection[] = 'vidOffset=' . $this->keyValuePairs[self::OPTION_ID_OFFSET];
        }

        if($this->keyValuePairs->hasKey(self::OPTION_TIMESTAMP_FROM)) {
            $queryStringCollection[] = 'fromTimestamp=' . $this->keyValuePairs[self::OPTION_TIMESTAMP_FROM];
        }

        if($this->keyValuePairs->hasKey(self::OPTION_TIMESTAMP_TO)) {
            $queryStringCollection[] = 'toTimestamp=' . $this->keyValuePairs[self::OPTION_TIMESTAMP_TO];
        }

        if($this->keyValuePairs->hasKey(self::OPTION_AGGREGATION)) {
            $queryStringCollection[] = 'aggregationProperty=' . $this->keyValuePairs[self::OPTION_AGGREGATION];
        }

        if($this->keyValuePairs->hasKey(self::OPTION_TIME_OFFSET)) {
            $queryStringCollection[] = 'timeOffset=' . $this->keyValuePairs[self::OPTION_TIME_OFFSET];
        }

        if($this->keyValuePairs->hasKey(self::OPTION_SEARCH)) {
            $queryStringCollection[] = 'q=' . $this->keyValuePairs[self::OPTION_SEARCH];
        }

        if($this->keyValuePairs->hasKey(self::OPTION_SORT)) {
            $display = 'sort=' . $this->keyValuePairs[self::OPTION_SORT];

            if($this->keyValuePairs->hasKey(self::OPTION_ORDER_ASCENDING)) {
                $display .= '&order=' . $this->keyValuePairs[self::OPTION_ORDER_ASCENDING];
            }

            $queryStringCollection[] = $display;
        }

        if($this->keyValuePairs->hasKey(self::OPTION_PROPERTY_MODE)) {
            $queryStringCollection[] = 'propertyMode=' . $this->keyValuePairs[self::OPTION_PROPERTY_MODE];
        }

        if($this->keyValuePairs->hasKey(self::OPTION_FORM_SUBMISSION_MODE)) {
            $queryStringCollection[] = 'formSubmissionMode=' . $this->keyValuePairs[self::OPTION_FORM_SUBMISSION_MODE];
        }

        if($this->keyValuePairs->hasKey(self::OPTION_SHOW_LIST_MEMBERSHIP)) {
            $queryStringCollection[] = 'showListMemberships=true';
        }

        if($this->keyValuePairs->hasKey(self::OPTION_SHOW_DELETED)) {
            $queryStringCollection[] = 'includeDeletes=true';
        }

        return $queryStringCollection->isEmpty() ? '' : $queryStringCollection->join('&');
    }
}