<?php

namespace Hubspot\Psr7\Builder;

interface QueryStringInterface
{
    public function setRequiredOptions(array $options);

    public function setOptionalOptions(array $options);

    public function checkAndClean();

    public function getQueryString();
}