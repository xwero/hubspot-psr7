<?php


namespace Hubspot\Psr7\Builder;

use Ds\Map;
use Exception;

final class EndpointBuilder implements EndpointBuilderInterface
{
    const BASE_URL = 'https://api.hubapi.com';
    const OPTION_REPLACEMENTS = 1;
    const OPTION_QUERY_STRING = 2;

    private $endpoint = '';
    private $authorisation;
    private $options;

    public function __construct(string $endpoint, AuthorisationInterface $authorisation)
    {
        $this->checkEndpoint($endpoint);

        $options = new Map();

        $options->put(self::OPTION_REPLACEMENTS, new Map([':apiversion' => 'v1']));

        $this->options = $options;

        $this->endpoint = $endpoint;
        $this->authorisation = $authorisation;
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
        $this->options[self::OPTION_REPLACEMENTS]->putAll($replacements);

        return $this;
    }

    public function setQueryString(QueryStringInterface $queryString, array $optionalOptions = [], array $requiredOptions = [])
    {
        if(count($optionalOptions) > 0) {
            $queryString->setOptionalOptions($optionalOptions);
        }

        if(count($requiredOptions) > 0) {
            $queryString->setRequiredOptions($requiredOptions);
        }

        $queryString->checkAndClean();

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
            $endpoint = str_replace($this->options[self::OPTION_REPLACEMENTS]->keys()->toArray(), $this->options[self::OPTION_REPLACEMENTS]->values()->toArray(), $endpoint);
        }

        $queryString = $this->options->hasKey(self::OPTION_QUERY_STRING) ? $this->options->get(self::OPTION_QUERY_STRING) : '' ;
        $queryString = $this->authorisation->addToQueryString($queryString);

        return self::BASE_URL . $endpoint . $queryString;
    }

    private function checkEndpoint(string $endpoint)
    {
        if (empty(trim($endpoint))) {
            throw  new Exception('EndpointBuilder error: empty endpoint.');
        }

        if ($endpoint[0] !== '/') {
            throw  new Exception('EndpointBuilder error: endpoint did not start with a forward slash.');
        }

        if(strpos($endpoint, ':apiversion') === FALSE) {
            throw  new Exception('EndpointBuilder error: endpoint did not have an :apiversion url fragment.');
        }
    }
}