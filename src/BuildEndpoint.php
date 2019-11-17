<?php


namespace Hubspot\Psr7;

use Ds\Map;
use Exception;
use QueryString;

final class BuildEndpoint
{
    const BASE_URL = 'https://api.hubapi.com';
    const OPTION_REPLACEMENTS = 1;
    const OPTION_QUERY_STRING = 2;

    private $endpoint = '';
    private $options;

    public function __construct(string $endpoint)
    {
        $this->checkEndpoint($endpoint);

        $options = new Map();

        $options->put(self::OPTION_REPLACEMENTS, new Map([':apiversion' => 'v1']));

        $this->options = $options;

        $this->endpoint = $endpoint;
    }

    public function setVersion2()
    {
        $this->options[self::OPTION_REPLACEMENTS][':apiversion'] = 'v2';

        return $this;
    }

    public function setVersion3()
    {
        $this->options[self::OPTION_REPLACEMENTS][':apiversion'] = 'v3';

        return $this;
    }

    public function setReplacements(array $replacements) {
        $this->options[self::OPTION_REPLACEMENTS]->merge($replacements);

        return $this;
    }

    public function setQueryString(QueryString $queryString, array $allowedOptions = [])
    {
        if(count($allowedOptions) > 0) {
            $queryString->clean($allowedOptions);
        }

        $this->options->put(self::OPTION_QUERY_STRING, $queryString->getQueryString());

        return $this;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getEndpoint(): string
    {
        $this->checkEndpoint($this->endpoint);

        $endpoint = $this->endpoint;

        if($this->options->hasKey(self::OPTION_REPLACEMENTS)) {
            $endpoint = str_replace($this->options[self::OPTION_REPLACEMENTS]->keys(), $this->options[self::OPTION_REPLACEMENTS]->values(), $endpoint);
        }
        //TODO authentication querystring
        $queryString = '';

        if($this->options->hasKey(self::OPTION_QUERY_STRING)) {
            $queryString = '?' . $this->options->get(self::OPTION_QUERY_STRING);
        }

        return self::BASE_URL . $endpoint . $queryString;
    }

    private function checkEndpoint(string $endpoint)
    {
        if (empty(trim($endpoint))) {
            throw  new Exception('BuildEndpoint error: empty endpoint.');
        }

        if ($endpoint[0] !== '/') {
            throw  new Exception('BuildEndpoint error: endpoint did not start with a forward slash.');
        }

        if(strpos(':apiversion', $endpoint) === FALSE) {
            throw  new Exception('BuildEndpoint error: endpoint did not have an :apiversion url fragment.');
        }
    }
}