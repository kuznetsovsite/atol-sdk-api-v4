<?php

namespace SaveTime\AtolV4\DTO;

use SaveTime\AtolV4\handbooks\PaymentTypes;

class Payment extends BaseDataObject
{
    /** @var float */
    protected $sum;
    /** @var string */
    protected $type;

    /**
     * Payment constructor.
     * @param PaymentTypes $paymentType
     * @param double $sum
     */
    public function __construct(PaymentTypes $paymentType, $sum)
    {
        $this->sum = (double)$sum;
        $this->type = $paymentType->getValue();
    }

    /**
     * @return float
     */
    public function getSum(): float
    {
        return $this->sum;
    }
}