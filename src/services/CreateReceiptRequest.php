<?php

namespace SaveTime\AtolV4\services;

use SaveTime\AtolV4\DTO\Receipt;
use SaveTime\AtolV4\DTO\Service;

class CreateReceiptRequest extends BaseServiceRequest
{

    /** @var string */
    protected $external_id;
    /** @var Receipt */
    protected $receipt;
    /** @var Service */
    protected $service;
    /** @var string идентификатор группы ККТ */
    private $groupCode;
    /** @var string */
    private $token;

    /**
     * CreateDocumentRequest constructor.
     * @param string $token
     * @param string $groupCode
     * @param string $externalId
     * @param Receipt $receipt
     */
    public function __construct(string $token, string $groupCode, string $externalId, Receipt $receipt)
    {
        $this->token = $token;
        $this->groupCode = $groupCode;
        $this->external_id = $externalId;
        $this->receipt = $receipt;
    }

    /**
     * @param Service $service
     * @return self
     */
    public function addService(Service $service): self
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = parent::getHeaders();
        $headers[] = 'Token: ' . $this->token;
        return $headers;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $params = parent::getParameters();
        $params['timestamp'] = date('d.m.Y H:i:s');
        return $params;
    }

    /**
     * @return Receipt
     */
    public function getReceipt(): Receipt
    {
        return $this->receipt;
    }

    /**
     * @inheritdoc
     */
    public function getRequestUrl()
    {
        return $this->getBaseUrl() . $this->groupCode . '/' . $this->receipt->getOperationType();
    }
}
