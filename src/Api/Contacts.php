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
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact');
        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestData = new BuildProperties($properties);
        $requestBody = json_encode($requestData);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function updateContactById(int $id, array $properties)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/vid/:vid/profile');

        $endpoint->setReplacements([':vid' => $id]);

        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestData = new BuildProperties($properties);
        $requestBody = json_encode($requestData);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function updateContactByEmail(string $email, array $properties)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/email/:email/profile');

        $endpoint->setReplacements([':email' => $email]);

        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestData = new BuildProperties($properties);
        $requestBody = json_encode($requestData);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function createOrUpdateContactByEmail(string $email, array $properties)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/createOrUpdate/email/:email');

        $endpoint->setReplacements([':email' => $email]);

        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestData = new BuildProperties($properties);
        $requestBody = json_encode($requestData);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function createOrUpdateContacts(BuildContacts $contacts)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/batch/');
        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestBody = json_encode($contacts);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function deleteContactById($id)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/vid/:id', );

        $endpoint->setReplacements([':id' => $id]);

        $request = $this->psr17Factory->createRequest('DELETE', $endpoint);

        return $request;
    }

    public function getAllContacts(QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/lists/all/contacts/all');

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getRecentlyModifiedContacts(QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/lists/recently_updated/contacts/recent');

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getRecentlyCreatedContacts($queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/lists/all/contacts/recent');

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getContactById(int $id, QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/vid/:vid/profile');

        $endpoint->setReplacements([':vid' => $id])
                ->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getContactByEmail(string $email, QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/email/:email/profile');

        $endpoint->setReplacements([':email' => $email])
            ->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getContactsById(QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/vids/batch/');

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function getContactByToken(string $token, QueryString $queryString = NULL)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/utk/:token/profile');

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
        $endpoint = new BuildEndpoint('/contacts/:apiversion/search/query');

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }

    public function mergeContact($primaryId, $secondaryId)
    {
        $endpoint = new BuildEndpoint('/contacts/:apiversion/contact/merge-vids/:id/');

        $endpoint->setReplacements([':id' => $primaryId]);

        $request = $this->psr17Factory->createRequest('POST', $endpoint);
        $requestBody = json_encode(['vidToMerge' => $secondaryId]);

        $request->getBody()->write($requestBody);

        return $request;
    }

    public function getLifecycleStageMetrics(QueryString $queryString)
    {
        $endpoint = new BuildEndpoint('/contacts/search/:apiversion/external/lifecyclestages');

        $endpoint->setQueryString($queryString);

        $request = $this->psr17Factory->createRequest('GET', $endpoint);

        return $request;
    }
}