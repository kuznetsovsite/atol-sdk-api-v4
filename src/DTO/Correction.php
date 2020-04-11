<?php

namespace SaveTime\AtolV4\DTO;

use SaveTime\AtolV4\handbooks\CorrectionOperationTypes;

class Correction extends BaseDataObject
{
    /** @var Company */
    protected $company;
    /** @var CorrectionInfo */
    protected $correction_info;
    /** @var CorrectionOperationTypes */
    private $operationType;
    /** @var Payment[] */
    private $payments;
    /** @var Vat */
    private $vats;

    /**
     * Correction constructor.
     * @param CorrectionOperationTypes $operationType
     * @param Company $company
     * @param CorrectionInfo $correctionInfo
     * @param Payment $payment
     * @param Vat $vat
     */
    public function __construct(CorrectionOperationTypes $operationType, Company $company, CorrectionInfo $correctionInfo, Payment $payment, Vat $vat)
    {
        $this->operationType = $operationType->getValue();
        $this->company = $company;
        $this->correction_info = $correctionInfo;
        $this->addPayment($payment);
        $this->addVat($vat);
    }

    /**
     * @param Payment $payment
     * @return self
     */
    public function addPayment(Payment $payment): self
    {
        $this->payments[] = $payment;
        return $this;
    }

    /**
     * @param Vat $vat
     * @return self
     */
    public function addVat(Vat $vat): self
    {
        $this->vats[] = $vat;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperationType()
    {
        return $this->operationType;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $parameters = parent::getParameters();
        foreach ($this->payments as $payment) {
            $parameters['payments'][] = $payment->getParameters();
        }
        foreach ($this->vats as $vat) {
            $parameters['vats'][] = $vat->getParameters();
        }

        return $parameters;
    }
}