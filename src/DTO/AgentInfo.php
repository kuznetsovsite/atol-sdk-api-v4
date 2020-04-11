<?php

namespace SaveTime\AtolV4\DTO;

use SaveTime\AtolV4\handbooks\AgentTypes;

class AgentInfo extends BaseDataObject
{
    /** @var MoneyTransferOperator */
    protected $money_transfer_operator;
    /** @var PayingAgent */
    protected $paying_agent;
    /** @var ReceivePaymentsOperator */
    protected $receive_payments_operator;
    /** @var string */
    protected $type;
    /** @var Supplier */
    private $supplier_info;

    public function __construct(AgentTypes $type, Supplier $supplier)
    {
        $this->type = $type->getValue();
        $this->supplier_info = $supplier;
    }

    /**
     * @param MoneyTransferOperator $moneyTransferOperator
     * @return self
     */
    public function addMoneyTransferOperator(MoneyTransferOperator $moneyTransferOperator): self
    {
        $this->money_transfer_operator = $moneyTransferOperator;
        return $this;
    }

    /**
     * @param PayingAgent $payingAgent
     * @return self
     */
    public function addPayingAgent(PayingAgent $payingAgent): self
    {
        $this->paying_agent = $payingAgent;
        return $this;
    }

    /**
     * @param ReceivePaymentsOperator $receivePaymentOperator
     * @return self
     */
    public function addReceivePaymentsOperator(ReceivePaymentsOperator $receivePaymentOperator): self
    {
        $this->receive_payments_operator = $receivePaymentOperator;
        return $this;
    }

    /**
     * @return Supplier
     */
    public function getSupplierInfo()
    {
        return $this->supplier_info;
    }
}