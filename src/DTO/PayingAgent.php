<?php

namespace SaveTime\AtolV4\DTO;

class PayingAgent extends BaseDataObject
{
    /** @var string */
    protected $operation;
    /** @var string[] */
    protected $phones;

    /**
     * PayingAgent constructor.
     * @param string $operation
     */
    public function __construct($operation)
    {
        $this->operation = (string)$operation;
    }

    /**
     * @param $phone
     * @return self
     */
    public function addPhone($phone): self
    {
        $this->phones[] = (string)$phone;
        return $this;
    }
}