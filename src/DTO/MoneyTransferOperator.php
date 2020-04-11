<?php

namespace SaveTime\AtolV4\DTO;

class MoneyTransferOperator extends BaseDataObject
{
    /** @var string */
    protected $address;
    /** @var int */
    protected $inn;
    /** @var string */
    protected $name;
    /** @var int[] */
    private $phones;

    /**
     * MoneyTransferOperator constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = (string)$name;
    }

    /**
     * @param string $address
     * @return self
     */
    public function addAddress($address): self
    {
        $this->address = (string)$address;
        return $this;
    }

    /**
     * @param int $inn
     * @return self
     */
    public function addInn($inn): self
    {
        $this->inn = (string)$inn;
        return $this;
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