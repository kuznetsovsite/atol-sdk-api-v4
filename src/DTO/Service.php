<?php

namespace SaveTime\AtolV4\DTO;

class Service extends BaseDataObject
{
    /** @var string */
    protected $callbackUrl;

    public function __construct($callbackUrl)
    {
        $this->callbackUrl = (string)$callbackUrl;
    }
}