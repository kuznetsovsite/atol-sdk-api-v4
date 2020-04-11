<?php

namespace SaveTime\AtolV4\DTO;

class Supplier extends BaseDataObject
{
    /** @var int */
    protected $inn;
    /** @var string */
    protected $name;
    /** @var int[] */
    private $phones;

    /**
     * Supplier constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = (string)$name;
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