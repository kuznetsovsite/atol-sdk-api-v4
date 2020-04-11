<?php

namespace SaveTime\AtolV4\DTO;

class ReceivePaymentsOperator extends BaseDataObject
{
    /** @var int[] */
    protected $phones;

    /**
     * ReceivePaymentsOperator constructor.
     * @param int $phone
     */
    public function __construct($phone)
    {
        $this->phones[] = (string)$phone;
    }

    /**
     * @param int $phone
     * @return self
     */
    public function addPhone($phone): self
    {
        $this->phones[] = (string)$phone;
        return $this;
    }
}