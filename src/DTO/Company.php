<?php

namespace SaveTime\AtolV4\DTO;

use SaveTime\AtolV4\handbooks\SnoTypes;

class Company extends BaseDataObject
{
    /** @var string */
    protected $email;
    /** @var int */
    protected $inn;
    /** @var string */
    protected $payment_address;
    /** @var string */
    protected $sno;

    public function __construct($email, SnoTypes $sno, $inn, $paymentAddress)
    {
        $this->email = (string)$email;
        $this->sno = $sno->getValue();
        $this->inn = (string)$inn;
        $this->payment_address = (string)$paymentAddress;
    }
}