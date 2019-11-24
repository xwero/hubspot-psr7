<?php


namespace Hubspot\Psr7\Request;

use Hubspot\Psr7\Builder\ContactQueryStringBuilder;
use Hubspot\Psr7\Builder\ContactsBuilder;
use Hubspot\Psr7\Builder\EndpointBuilder;
use Hubspot\Psr7\Builder\PropertiesBuilder;
use Hubspot\Psr7\Builder\QueryStringInterface;
use SebastianBergmann\CodeCoverage\TestFixture\C;


final class ContactsRequest extends Base
{
    public function createContact(array $properties)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/contact', $this->authorisation);
        $body = new PropertiesBuilder($properties);

        return $this->buildRequest(self::METHOD_POST, $endpoint->getEndpoint(), $body);
    }

    public function updateContactById(int $id, array $properties)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/contact/vid/:vid/profile', $this->authorisation);

        $endpoint->setReplacements([':vid' => $id]);

        $body = new PropertiesBuilder($properties);

        return $this->buildRequest(self::METHOD_POST, $endpoint->getEndpoint(), $body);
    }

    public function updateContactByEmail(string $email, array $properties)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/contact/email/:email/profile', $this->authorisation);

        $endpoint->setReplacements([':email' => $email]);

        $body = new PropertiesBuilder($properties);

        return $this->buildRequest(self::METHOD_POST, $endpoint->getEndpoint(), $body);
    }

    public function createOrUpdateContactByEmail(string $email, array $properties)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/contact/createOrUpdate/email/:email', $this->authorisation);

        $endpoint->setReplacements([':email' => $email]);

        $body = new PropertiesBuilder($properties);

        return $this->buildRequest(self::METHOD_POST, $endpoint->getEndpoint(), $body);
    }

    public function createOrUpdateContacts(ContactsBuilder $contacts)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/contact/batch/', $this->authorisation);

        return $this->buildRequest(self::METHOD_POST, $endpoint->getEndpoint(), $contacts);
    }

    public function deleteContactById($id)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/contact/vid/:id', $this->authorisation);

        $endpoint->setReplacements([':id' => $id]);

        return $this->buildRequest(self::METHOD_DELETE, $endpoint->getEndpoint());
    }

    public function getAllContacts(QueryStringInterface $queryString = NULL)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/lists/all/contacts/all', $this->authorisation);

        if($queryString instanceof QueryStringInterface) {
            $optionalOptions = [
                ContactQueryStringBuilder::OPTION_COUNT,
                ContactQueryStringBuilder::OPTION_ID_OFFSET,
                ContactQueryStringBuilder::OPTION_PROPERTIES,
                ContactQueryStringBuilder::OPTION_PROPERTY_MODE,
                ContactQueryStringBuilder::OPTION_FORM_SUBMISSION_MODE,
                ContactQueryStringBuilder::OPTION_SHOW_LIST_MEMBERSHIP
            ];

            $endpoint->setQueryString($queryString, $optionalOptions);
        }

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function getRecentlyModifiedContacts(QueryStringInterface $queryString = NULL)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/lists/recently_updated/contacts/recent', $this->authorisation);

        if($queryString instanceof QueryStringInterface) {
            $optionalOptions = [
                ContactQueryStringBuilder::OPTION_COUNT,
                ContactQueryStringBuilder::OPTION_ID_OFFSET,
                ContactQueryStringBuilder::OPTION_TIME_OFFSET,
                ContactQueryStringBuilder::OPTION_PROPERTIES,
                ContactQueryStringBuilder::OPTION_PROPERTY_MODE,
                ContactQueryStringBuilder::OPTION_FORM_SUBMISSION_MODE,
                ContactQueryStringBuilder::OPTION_SHOW_LIST_MEMBERSHIP
            ];

            $endpoint->setQueryString($queryString, $optionalOptions);
        }

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function getRecentlyCreatedContacts(QueryStringInterface $queryString = NULL)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/lists/all/contacts/recent', $this->authorisation);

        if($queryString instanceof QueryStringInterface) {
            $optionalOptions = [
                ContactQueryStringBuilder::OPTION_COUNT,
                ContactQueryStringBuilder::OPTION_ID_OFFSET,
                ContactQueryStringBuilder::OPTION_TIME_OFFSET,
                ContactQueryStringBuilder::OPTION_PROPERTIES,
                ContactQueryStringBuilder::OPTION_PROPERTY_MODE,
                ContactQueryStringBuilder::OPTION_FORM_SUBMISSION_MODE,
                ContactQueryStringBuilder::OPTION_SHOW_LIST_MEMBERSHIP
            ];

            $endpoint->setQueryString($queryString, $optionalOptions);
        }

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function getContactById(int $id, QueryStringInterface $queryString = NULL)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/contact/vid/:vid/profile', $this->authorisation);

        $endpoint->setReplacements([':vid' => $id]);

        if($queryString instanceof QueryStringInterface) {
            $optionalOptions = [
                ContactQueryStringBuilder::OPTION_PROPERTIES,
                ContactQueryStringBuilder::OPTION_PROPERTY_MODE,
                ContactQueryStringBuilder::OPTION_FORM_SUBMISSION_MODE,
                ContactQueryStringBuilder::OPTION_SHOW_LIST_MEMBERSHIP
            ];

            $endpoint->setQueryString($queryString, $optionalOptions);
        }

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function getContactByEmail(string $email, QueryStringInterface $queryString = NULL)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/contact/email/:email/profile', $this->authorisation);

        $endpoint->setReplacements([':email' => $email]);

        if($queryString instanceof QueryStringInterface) {
            $optionalOptions = [
                ContactQueryStringBuilder::OPTION_PROPERTIES,
                ContactQueryStringBuilder::OPTION_PROPERTY_MODE,
                ContactQueryStringBuilder::OPTION_FORM_SUBMISSION_MODE,
                ContactQueryStringBuilder::OPTION_SHOW_LIST_MEMBERSHIP
            ];

            $endpoint->setQueryString($queryString, $optionalOptions);
        }

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function getContactsById(array $ids, QueryStringInterface $queryString = null)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/contact/vids/batch/', $this->authorisation);

        if ($queryString instanceof QueryStringInterface) {
            $queryString->addIds($ids);
        } else {
            $queryString = (new ContactQueryStringBuilder())
                                ->addIds($ids);
        }

        $optionalOptions = [
            ContactQueryStringBuilder::OPTION_PROPERTY_MODE,
            ContactQueryStringBuilder::OPTION_FORM_SUBMISSION_MODE,
            ContactQueryStringBuilder::OPTION_SHOW_LIST_MEMBERSHIP,
            ContactQueryStringBuilder::OPTION_SHOW_DELETED
        ];

        $requiredOptions = [
            ContactQueryStringBuilder::OPTION_IDS,
        ];

        $endpoint->setQueryString($queryString, $optionalOptions, $requiredOptions);

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function getContactByToken(string $token, QueryStringInterface $queryString = NULL)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/contact/utk/:token/profile', $this->authorisation);

        $endpoint->setReplacements([':token' => $token]);

        if($queryString instanceof QueryStringInterface) {
            $optionalOptions = [
                ContactQueryStringBuilder::OPTION_PROPERTIES,
                ContactQueryStringBuilder::OPTION_PROPERTY_MODE,
                ContactQueryStringBuilder::OPTION_FORM_SUBMISSION_MODE,
                ContactQueryStringBuilder::OPTION_SHOW_LIST_MEMBERSHIP
            ];

            $endpoint->setQueryString($queryString, $optionalOptions);
        }

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    /**
     * Search contacts based on email, name, phone number and company
     *
     * @param string $queryString
     * @return \Psr\Http\Message\RequestInterface
     */
    public function searchContacts(string $search, QueryStringInterface $queryString = null)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/search/query', $this->authorisation);

        if($queryString instanceof QueryStringInterface) {
            $queryString->setSearch($search);
        } else {
            $queryString = (new ContactQueryStringBuilder())->setSearch($search);
        }

        $optionalOptions = [
            ContactQueryStringBuilder::OPTION_PROPERTIES,
            ContactQueryStringBuilder::OPTION_COUNT,
            ContactQueryStringBuilder::OPTION_OFFSET,
            ContactQueryStringBuilder::OPTION_SORT,
            ContactQueryStringBuilder::OPTION_ORDER_ASCENDING
        ];

        $requiredOptions = [
            ContactQueryStringBuilder::OPTION_SEARCH
        ];

        $endpoint->setQueryString($queryString, $optionalOptions, $requiredOptions);

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }

    public function mergeContact($primaryId, $secondaryId)
    {
        $endpoint = new EndpointBuilder('/contacts/:apiversion/contact/merge-vids/:id/', $this->authorisation);

        $endpoint->setReplacements([':id' => $primaryId]);

        $body = ['vidToMerge' => $secondaryId];

        return $this->buildRequest(self::METHOD_POST, $endpoint->getEndpoint(), $body);
    }

    public function getLifecycleStageMetrics(int $fromTimestamp, int $toTimestamp, QueryStringInterface $queryString = NULL)
    {
        $endpoint = new EndpointBuilder('/contacts/search/:apiversion/external/lifecyclestages', $this->authorisation);

        if($queryString instanceof QueryStringInterface) {
            $queryString->setToTimestamp($toTimestamp)->setFromTimestamp($fromTimestamp);
        } else {
            $queryString = (new ContactQueryStringBuilder())
                                ->setToTimestamp($toTimestamp)
                                ->setFromTimestamp($fromTimestamp);
        }

        $optionalOptions = [
            ContactQueryStringBuilder::OPTION_AGGREGATION
        ];

        $requiredOptions = [
            ContactQueryStringBuilder::OPTION_TIMESTAMP_TO,
            ContactQueryStringBuilder::OPTION_TIMESTAMP_FROM
        ];

        $endpoint->setQueryString($queryString, $optionalOptions, $requiredOptions);

        return $this->buildRequest(self::METHOD_GET, $endpoint->getEndpoint());
    }
}