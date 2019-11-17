<?php


namespace Hubspot\Psr7;


use JsonSerializable;

class BuildContacts implements JsonSerializable
{
    const BY_EMAIL = 'email';
    const BY_ID = 'vid';

    private $contacts = [];

    public function __construct(string $identifyBy, $identityValue, array $properties)
    {
        $this->addContact($identifyBy, $identityValue, $properties);
    }

    public function addContact(string $identifyBy, $identityValue, array $properties)
    {
        $contactProperties = (new BuildProperties($properties))->toArray();
        $contact = array_merge([$identifyBy => $identityValue], $contactProperties);

        $this->contacts[] = $contact;
    }

    public function jsonSerialize()
    {
        return $this->contacts;
    }
}