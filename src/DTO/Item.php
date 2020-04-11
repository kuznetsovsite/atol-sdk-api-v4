<?php

namespace SaveTime\AtolV4\DTO;

use SaveTime\AtolV4\handbooks\PaymentMethods;
use SaveTime\AtolV4\handbooks\PaymentObjects;

class Item extends BaseDataObject
{

    /** @var AgentInfo */
    protected $agent_info;
    /** @var string */
    protected $measurement_unit;
    /** @var string */
    protected $name;
    /** @var string */
    protected $payment_method;
    /** @var string */
    protected $payment_object;
    /** @var float */
    protected $price;
    /** @var int */
    protected $quantity;
    /** @var float */
    protected $sum;
    /** @var Supplier */
    protected $supplier_info;
    /** @var string */
    protected $user_data;
    /** @var Vat */
    protected $vat;

    /**
     * @param string $name Описание товара
     * @param double $price Цена единицы товара
     * @param float $quantity Количество товара
     * @param Vat $vat
     * @param double $sum Сумма количества товаров. Передается если количество * цену товара не равно sum
     */
    public function __construct($name, $price, $quantity, Vat $vat, $sum = null)
    {
        $this->name = (string)$name;
        $this->price = (double)$price;
        $this->quantity = (double)$quantity;
        if (!$sum) {
            $this->sum = (double)$this->quantity * $this->price;
        } else {
            $this->sum = (double)$sum;
        }
        $this->vat = $vat;
    }

    /**
     * @param AgentInfo $agentInfo
     * @return self
     */
    public function addAgentInfo(AgentInfo $agentInfo): self
    {
        $this->agent_info = $agentInfo;
        $this->supplier_info = $agentInfo->getSupplierInfo();
        return $this;
    }

    /**
     * @param string $measuringUnit
     * @return self
     */
    public function addMeasurementUnit($measuringUnit): self
    {
        $this->measurement_unit = (string)$measuringUnit;
        return $this;
    }

    /**
     * @param PaymentMethods $paymentMethod
     * @return self
     */
    public function addPaymentMethod(PaymentMethods $paymentMethod): self
    {
        $this->payment_method = $paymentMethod->getValue();
        return $this;
    }

    /**
     * @param PaymentObjects $paymentObject
     * @return self
     */
    public function addPaymentObject(PaymentObjects $paymentObject): self
    {
        $this->payment_object = $paymentObject->getValue();
        return $this;
    }

    /**
     * @param string $userData
     * @return self
     */
    public function addUserData($userData): self
    {
        $this->user_data = (string)$userData;
        return $this;
    }

    /**
     * Получить сумму позиции
     * @return float
     */
    public function getPositionSum()
    {
        return $this->sum;
    }
}
