<?php


namespace Hubspot\Psr7\Api;

use Hubspot\Psr7\BuildContacts;
use Hubspot\Psr7\BuildEndpoint;
use Hubspot\Psr7\BuildProperties;
use QueryString;

final class Contacts extends Base
{


    public function createContact(array $properties)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact', $this->apiKey);
        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestData = new BuildProperties($properties);
        $requestBody = json_encode($requestData);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function updateContactById(int $id, array $properties)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/vid/:vid/profile', $this->apiKey);

        $endpoint->setReplacements([':vid' => $id]);

        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestData = new BuildProperties($properties);
        $requestBody = json_encode($requestData);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function updateContactByEmail(string $email, array $properties)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/email/:email/profile', $this->apiKey);

        $endpoint->setReplacements([':email' => $email]);

        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestData = new BuildProperties($properties);
        $requestBody = json_encode($requestData);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function createOrUpdateContactByEmail(string $email, array $properties)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/createOrUpdate/email/:email', $this->apiKey);

        $endpoint->setReplacements([':email' => $email]);

        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestData = new BuildProperties($properties);
        $requestBody = json_encode($requestData);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function createOrUpdateContacts(BuildContacts $contacts)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/batch/', $this->apiKey);
        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestBody = json_encode($contacts);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function deleteContactById($id)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/vid/:id', $this->apiKey);

        $endpoint->setReplacements([':id' => $id]);

        $request = $this->psr17Factory->createRequest('DELETE', $endpoint);

        return $request;
    }

    public function getAllContacts(QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/lists/all/contacts/all', $this->apiKey);

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getRecentlyModifiedContacts(QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/lists/recently_updated/contacts/recent', $this->apiKey);

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getRecentlyCreatedContacts($queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/lists/all/contacts/recent', $this->apiKey);

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getContactById(int $id, QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/vid/:vid/profile', $this->apiKey);

        $endpoint->setReplacements([':vid' => $id])
                ->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getContactByEmail(string $email, QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/email/:email/profile', $this->apiKey);

        $endpoint->setReplacements([':email' => $email])
            ->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getContactsById(QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/vids/batch/', $this->apiKey);

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getContactByToken(string $token, QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/utk/:token/profile', $this->apiKey);

        $endpoint->setReplacements([':token' => $token])
                ->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    /**
     * Search contacts based on email, name, phone number and company
     *
     * @param string $queryString
     * @return \Psr\Http\Message\RequestInterface
     */
    public function searchContacts(QueryString $queryString)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/search/query', $this->apiKey);

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function mergeContact($primaryId, $secondaryId)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/merge-vids/:id/', $this->apiKey);

        $endpoint->setReplacements([':id' => $primaryId]);

        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestBody = json_encode(['vidToMerge' => $secondaryId]);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function getLifecycleStageMetrics(QueryString $queryString)
    {
        $endpoint = new BuildEndpoint('/contacts/search/:apiversion/external/lifecyclestages', $this->apiKey);

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }
}