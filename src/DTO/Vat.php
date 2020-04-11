<?php

namespace SaveTime\AtolV4\DTO;

use SaveTime\AtolV4\handbooks\Vates;

class Vat extends BaseDataObject
{
    /** @var float */
    protected $sum;
    /** @var string */
    protected $type;

    public function __construct(Vates $type)
    {
        $this->type = $type->getValue();
    }

    public function addSum($sum): self
    {
        $this->sum = $this->getTaxAmount($sum);
        return $this;
    }

    /**
     * Получить сумму налога
     * @param float $amount
     * @return float
     */
    protected function getTaxAmount($amount)
    {
        switch ($this->type) {
            case Vates::NONE:
            case Vates::VAT0:
                return round(0, 2);
            case Vates::VAT10:
            case Vates::VAT110:
                return round($amount * 10 / 110, 2);
            case Vates::VAT20:
            case Vates::VAT120:
                return round($amount * 20 / 120, 2);
        }
    }
}