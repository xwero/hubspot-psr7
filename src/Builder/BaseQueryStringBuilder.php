<?php


namespace Hubspot\Psr7\Builder;


use Ds\Map;
use Ds\Set;
use Ds\Vector;
use Hubspot\Psr7\Exception\RequiredQueryStringOptionsException;

abstract class BaseQueryStringBuilder implements QueryStringInterface
{
    const OPTION_OFFSET = 16;

    protected $keyValuePairs;
    protected $requiredOptions;
    protected $optionalOptions;

    public function __construct()
    {
        $this->keyValuePairs = new Map();
        $this->requiredOptions = new Vector();
        $this->optionalOptions = new Vector();
    }

    public function setRequiredOptions(array $options)
    {
        if(count($options) > 0) {
            $this->requiredOptions = new Vector($options);
        }
    }

    public function setOptionalOptions(array $options)
    {
        if(count($options) > 0) {
            $this->optionalOptions = new Vector($options);
        }
    }

    public function checkAndClean()
    {
        $allOptions = $this->keyValuePairs->keys();

        if($this->requiredOptions->count() > 0 && !$allOptions->contains(...$this->requiredOptions->toArray())) {
            throw new RequiredQueryStringOptionsException();
        }

        if($this->optionalOptions->count() > 0) {
            $allAllowed = $this->requiredOptions->merge($this->optionalOptions->toArray());
            $allAllowed = new Set($allAllowed->toArray());
            $notAllowed = $allOptions->diff($allAllowed);

            foreach ($notAllowed as $removeKey) {
                $this->keyValuePairs->remove($removeKey);
            }
        }
    }

    public function setOffset(int $offset)
    {
        $this->keyValuePairs->put(self::OPTION_OFFSET, $offset);

        return $this;
    }
}