<?php


use Hubspot\Psr7\Builder\AuthorisationBuilder;
use Hubspot\Psr7\Builder\ContactQueryStringBuilder;
use Hubspot\Psr7\Builder\ContactsBuilder;
use Hubspot\Psr7\Request\ContactsRequest;
use PHPUnit\Framework\TestCase;

class ContactsRequestTest extends TestCase
{
    private $request;

    protected function setUp(): void
    {
        $auth = new AuthorisationBuilder(AuthorisationBuilder::TYPE_KEY, 'a');
        $this->request = new ContactsRequest($auth);
    }

    public function testUpdateContactByEmail()
    {
        $request = $this->request->updateContactByEmail('a@b.c', ['property' => 'value']);

        $this->assertStringContainsString('a@b.c', $request->getUri()->getPath());
        $this->assertSame('{"properties":[{"property":"property","value":"value"}]}', (string) $request->getBody());
    }

    public function testCreateOrUpdateContactByEmail()
    {
        $request = $this->request->createOrUpdateContactByEmail('a@b.c', ['property' => 'value']);

        $this->assertStringContainsString('a@b.c', $request->getUri()->getPath());
        $this->assertSame('{"properties":[{"property":"property","value":"value"}]}', (string) $request->getBody());
    }

    public function testGetContactById()
    {
        $request = $this->request->getContactById(1);

        $this->assertStringContainsString(1, $request->getUri()->getPath());
    }

    public function testGetContactsById()
    {
        $request = $this->request->getContactsById([1, 2]);

        $this->assertStringContainsString(1, $request->getUri()->getQuery());
        $this->assertStringContainsString(2, $request->getUri()->getQuery());
    }

    public function testUpdateContactById()
    {
        $request = $this->request->updateContactById(1, ['property' => 'value']);

        $this->assertStringContainsString(1, $request->getUri()->getPath());
        $this->assertSame('{"properties":[{"property":"property","value":"value"}]}', (string) $request->getBody());
    }

    public function testGetContactByEmail()
    {
        $request = $this->request->getContactByEmail('a@b.c');

        $this->assertStringContainsString('a@b.c', $request->getUri()->getPath());
    }

    public function testSearchContacts()
    {
        $request = $this->request->searchContacts('a@b.c');

        $this->assertStringContainsString('a@b.c', $request->getUri()->getQuery());
    }

    public function testCreateContact()
    {
        $request = $this->request->createContact(['property' => 'value']);

        $this->assertSame('{"properties":[{"property":"property","value":"value"}]}', (string) $request->getBody());
    }

    public function testCreateOrUpdateContacts()
    {
        $contacts = new ContactsBuilder(ContactsBuilder::BY_ID, 1, ['property' => 'value']);
        $request = $this->request->createOrUpdateContacts($contacts);

        $this->assertSame('[{"vid":1,"properties":[{"property":"property","value":"value"}]}]', (string) $request->getBody());
    }

    public function testMergeContact()
    {
        $request = $this->request->mergeContact(1, 2);

        $this->assertStringContainsString(1, $request->getUri()->getPath());
        $this->assertStringContainsString(2, (string) $request->getBody());
    }

    public function testDeleteContactById()
    {
        $request = $this->request->deleteContactById(1);

        $this->assertStringContainsString(1, $request->getUri()->getPath());
    }

    public function testGetLifecycleStageMetrics()
    {
        $request = $this->request->getLifecycleStageMetrics(1, 2);

        $this->assertStringContainsString(1, $request->getUri()->getQuery());
        $this->assertStringContainsString(2, $request->getUri()->getQuery());
    }

    public function testGetContactByToken()
    {
        $request = $this->request->getContactByToken('a');

        $this->assertStringContainsString('a', $request->getUri()->getPath());
    }
}
