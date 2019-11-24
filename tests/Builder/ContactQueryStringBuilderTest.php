<?php

use Hubspot\Psr7\Builder\ContactQueryStringBuilder;
use PHPUnit\Framework\TestCase;

class ContactQueryStringBuilderTest extends TestCase
{

    public function testShowListMembership()
    {
        $qs = (new ContactQueryStringBuilder())
                ->showListMembership();

        $this->assertSame('showListMemberships=true', $qs->getQueryString());
    }

    public function testSetSort()
    {
        $qs = (new ContactQueryStringBuilder())
                ->setSort('a');

        $this->assertSame('sort=a', $qs->getQueryString());
    }

    public function testSetCount()
    {
        $qs = (new ContactQueryStringBuilder())
                ->setCount(1);

        $this->assertSame('count=1', $qs->getQueryString());
    }

    public function testOrderAscending()
    {
        $qs = (new ContactQueryStringBuilder())
                ->setSort('a')
                ->orderAscending();

        $this->assertSame('sort=a&order=ASC', $qs->getQueryString());
    }

    public function testIncludeDeleted()
    {
        $qs = (new ContactQueryStringBuilder())
                ->includeDeleted();

        $this->assertSame('includeDeletes=true', $qs->getQueryString());
    }

    public function testAddProperty()
    {
        $qs = (new ContactQueryStringBuilder())
                ->addProperty('a');


        $this->assertSame('property=a', $qs->getQueryString());
    }

    public function testAddProperties()
    {
        $qs = (new ContactQueryStringBuilder())
            ->addProperties(['a', 'b']);

        $this->assertSame('property=a&property=b', $qs->getQueryString());
    }

    public function testSetFullPropertyMode()
    {
        $qs = (new ContactQueryStringBuilder())
                ->setFormSubmissionMode(ContactQueryStringBuilder::SUBMISSION_MODE_ALL);

        $this->assertSame('formSubmissionMode=all', $qs->getQueryString());
    }

    public function testAddId()
    {
        $qs = (new ContactQueryStringBuilder())
                ->addId(1);

        $this->assertSame('vid=1', $qs->getQueryString());
    }

    public function testAddIds()
    {
        $qs = (new ContactQueryStringBuilder())
                ->addIds([1,2]);


        $this->assertSame('vid=1&vid=2', $qs->getQueryString());
    }

    public function testAddToken()
    {
        $qs = (new ContactQueryStringBuilder())
                ->addToken('a');

        $this->assertSame('utk=a', $qs->getQueryString());
    }

    public function testAddTokens()
    {
        $qs = (new ContactQueryStringBuilder())
                ->addTokens(['a', 'b']);

        $this->assertSame('utk=a&utk=b', $qs->getQueryString());
    }

    public function testSetIdOffset()
    {
        $qs = (new ContactQueryStringBuilder())
                ->setIdOffset(1);

        $this->assertSame('vidOffset=1', $qs->getQueryString());
    }

    public function testSetFormSubmissionMode()
    {
        $qs = (new ContactQueryStringBuilder())
                ->setFormSubmissionMode(ContactQueryStringBuilder::SUBMISSION_MODE_OLDEST);

        $this->assertSame('formSubmissionMode=oldest', $qs->getQueryString());
    }

    public function testSetTimeOffset()
    {
        $qs = (new ContactQueryStringBuilder())
                ->setTimeOffset(1);

        $this->assertSame('timeOffset=1', $qs->getQueryString());
    }

    public function testSetOffset()
    {
        $qs = (new ContactQueryStringBuilder())
            ->setOffset(1);

        $this->assertSame('offset=1', $qs->getQueryString());
    }

    public function testSetSearch()
    {
        $qs = (new ContactQueryStringBuilder())
                ->setSearch('a');

        $this->assertSame('q=a', $qs->getQueryString());
    }

    public function testSetToTimestamp()
    {
        $qs = (new ContactQueryStringBuilder())
                ->setToTimestamp(1514764800000);

        $this->assertSame('toTimestamp=1514764800000', $qs->getQueryString());
    }

    public function testSetFromTimestamp()
    {
        $qs = (new ContactQueryStringBuilder())
            ->setFromTimestamp(1514764800000);

        $this->assertSame('fromTimestamp=1514764800000', $qs->getQueryString());
    }

    public function testSetAggregationProperty()
    {
        $qs = (new ContactQueryStringBuilder())
            ->setAggregationProperty('a');

        $this->assertSame('aggregationProperty=a', $qs->getQueryString());
    }

    public function testCombined()
    {
        $qs = (new ContactQueryStringBuilder())
            ->setSearch('a')
            ->setIdOffset(1)
            ->includeDeleted();

        $this->assertSame('vidOffset=1&q=a&includeDeletes=true', $qs->getQueryString());
    }
}
