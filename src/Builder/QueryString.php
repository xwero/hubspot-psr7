<?php


interface QueryString
{
    public function clean(array $allowed);

    public function getQueryString();
}