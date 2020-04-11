<?php

namespace SaveTime\AtolV4\DTO;

use SaveTime\AtolV4\handbooks\ReceiptOperationTypes;

class Receipt extends BaseDataObject
{
    /** @var Client */
    protected $client;
    /** @var Company */
    protected $company;
    /** @var ItemCollection */
    private $items;
    /** @var string */
    private $operationType;
    /** @var PaymentCollection */
    private $payments;

    /**
     * Document constructor.
     * @param Client $client
     * @param Company $company
     * @param ItemCollection $items
     * @param PaymentCollection $payments
     * @param ReceiptOperationTypes $type
     */
    public function __construct(Client $client, Company $company, ItemCollection $items, PaymentCollection $payments, ReceiptOperationTypes $type)
    {
        $this->client = $client;
        $this->company = $company;
        $this->items = $items;
        $this->payments = $payments;
        $this->operationType = $type->getValue();
    }

    /**
     * @param Payment $payment
     * @return self
     */
    public function addPayment(Payment $payment): self
    {
        $this->payments->addItem($payment);
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
        $params = parent::getParameters();

        foreach ($this->items as $item) {
            $params['items'][] = $item->getParameters();
        }
        foreach ($this->payments as $payment) {
            $params['payments'][] = $payment->getParameters();
        }

        $params['total'] = (double)$this->getItemsAmount();

        return $params;
    }

    /**
     * @param Item $item
     * @return self
     */
    public function addItem(Item $item): self
    {
        $this->items->addItem($item);
        return $this;
    }

    /**
     * @return float
     */
    private function getItemsAmount()
    {
        $itemsAmount = 0;
        foreach ($this->items as $item) {
            // переводим в копейки
            $itemsAmount += $item->getPositionSum() * 100;
        }
        // переводим в рубли
        return $itemsAmount / 100;
    }
}