<?php


use Hubspot\Psr7\Builder\ContactsBuilder;
use PHPUnit\Framework\TestCase;

class ContactsBuilderTest extends TestCase
{

    public function testOneContact()
    {
        $contacts = new ContactsBuilder(ContactsBuilder::BY_EMAIL, 'a@b.c', ['d' => 'e']);
        $json = json_encode($contacts);

        $this->assertSame('[{"email":"a@b.c","properties":[{"property":"d","value":"e"}]}]', json_encode($contacts));
    }

    public function testTwoContacts()
    {
        $contacts = new ContactsBuilder(ContactsBuilder::BY_EMAIL, 'a@b.c', ['d' => 'e']);

        $contacts->addContact(ContactsBuilder::BY_ID, '1', ['d' => 'e']);

        $json = json_encode($contacts);

        $this->assertSame('[{"email":"a@b.c","properties":[{"property":"d","value":"e"}]},{"vid":"1","properties":[{"property":"d","value":"e"}]}]', json_encode($contacts));
    }
}
