<?php


namespace Hubspot\Psr7;


use Ds\Map;
use Ds\Set;
use Ds\Vector;
use QueryString;

class ContactQueryString implements QueryString
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

    private $keyValuePairs;

    public function __construct()
    {
        $this->keyValuePairs = new Map();
    }

    public function addProperty(string $property)
    {
        $properties = $this->keyValuePairs->get(self::OPTION_PROPERTIES, new Vector());

        $properties->set($property);

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

        $ids->set($id);

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

        $tokens->set($token);

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

    public function clean(array $allowed)
    {
        $allOptions = $this->keyValuePairs->keys();
        $notAllowed = $allOptions->diff(new Set($allowed));

        foreach ($notAllowed as $removeKey) {
            $this->keyValuePairs->remove($removeKey);
        }
    }

    public function getQueryString()
    {
        $queryStringCollection = new Vector();

        if(count($this->properties) > 0) {
            $queryStringCollection[] = 'property=' . join('&property=', $this->properties);
        }

        if(count($this->ids) > 0) {
            $queryStringCollection[] = 'vid=' . join('&vid=', $this->ids);
        }

        if(count($this->tokens) > 0) {
            $queryStringCollection[] = 'utk=' . join('&utk=', $this->tokens);
        }

        if($this->count !== 20) {
            $queryString = 'count=';
            $queryString .= $this->count > 100 ? 100 : $this->count;

            $queryStringCollection[] = $queryString;
        }

        if(is_int($this->offset)) {
            $queryStringCollection[] = 'vidOffset=' . $this->offset;
        }

        if(is_int($this->timeOffset)) {
            $queryStringCollection[] = 'timeOffset=' . $this->timeOffset;
        }

        if(is_string($this->search)) {
            $queryStringCollection[] = 'q=' . $this->search;
        }

        if(is_string($this->sort)) {
            $display = 'sort=' . $this->sort;

            if($this->order !== self::ORDER_DESC) {
                $display .= '&order=' . $this->order;
            }
        }

        if($this->propertyMode !== self::PROPERTY_MODE_VALUE) {
            $queryStringCollection[] = 'propertyMode=' . $this->propertyMode;
        }

        if($this->submissionMode !== self::SUBMISSION_MODE_NEWEST) {
            $queryStringCollection[] = 'formSubmissionMode=' . $this->submissionMode;
        }

        if($this->listMembership) {
            $queryStringCollection[] = 'showListMemberships=true';
        }

        if($this->includeDeleted) {
            $queryStringCollection[] = 'includeDeletes=true';
        }

        return $queryStringCollection->isEmpty() ? '' : $queryStringCollection->join('&');
    }
}