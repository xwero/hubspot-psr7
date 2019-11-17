# hubspot API PSR-7 

Most API wrappers come with their own client. Most of the time this is [Guzzle](http://docs.guzzlephp.org/en/stable/), because it is a great library.
But in Symfony 4.3 they introduced the [HttpClient component](https://symfony.com/doc/current/components/http_client.html) I think the time has come to create API wrappers for a standard instead of based on a client.
This standard is [PSR-7](https://www.php-fig.org/psr/psr-7/).

Providing library users with PSR-7 request and response handlers allows them to use the client they feel most comfortable with.
And it will work for years to come because a standard is not on a periodical release cycle.

I got the inspiration from the [Ryan Winchester Hubspot library](https://github.com/HubSpot/hubspot-php), which is now taken over by Hubspot.

So instead of doing:

```php
$hubspot = SevenShores\Hubspot\Factory(['key' => 'demo']);
$contact = $hubspot->contacts()->getByEmail("test@hubspot.com");

echo $contact->properties->email->value;
```

You do:

```php
$request = (new Hubspot\Psr7\Api\Contacts('demo'))->getContactByEmail("test@hubspot.com");
// your app is responsible for making the request and returning a PSR-7 response
$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
$psr18Client = new \Buzz\Client\Curl($psr17Factory);

echo (new Hubspot\Psr7\Response\Contacts($psr18Client->sendRequest($request))->getContactPropertyValue('email');
```

One of the things i was concerned for was a lot more code for the same action, but I think I was able to keep it short enough for people to make the switch.

