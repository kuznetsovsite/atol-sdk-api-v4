<?php

namespace SaveTime\AtolV4\services;

use SaveTime\AtolV4\DTO\Receipt;
use SaveTime\AtolV4\DTO\Service;
use SaveTime\AtolV4\handbooks\ReceiptOperationTypes;

class RefundRequest extends BaseServiceRequest
{
    /** @var array */
    protected $receipt;
    /** @var string идентификатор группы ККТ */
    private $groupCode;
    /** @var string */
    private $token;
    /** @var string */
    private $externalId;


    /**
     * CreateDocumentRequest constructor.
     * @param string $token
     * @param string $groupCode
     * @param array $receipt - на текущий момен прокидывается массив данных от ранее отправленного чека
     */
    public function __construct(string $groupCode, string $token, array $receipt, string $externalId)
    {
        $this->token        = $token;
        $this->groupCode    = $groupCode;
        $this->receipt      = $receipt;
        $this->externalId   = $externalId;
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
        /** @todo при маппинге нормальной DTO поправить */
        $params = $this->receipt;

        // приведение типов иначе не пройдем валидацию
        $params['external_id'] = (string)$this->externalId;
        foreach ($params['receipt']['items'] as &$item) {
            $item['price'] = (float)$item['price'];
            $item['quantity'] = (int)$item['quantity'];
            $item['sum'] = (float)$item['sum'];
        }
        foreach ($params['receipt']['payments'] as &$payment) {
            $payment['type'] = (int)$payment['type'];
            $payment['sum'] = (float)$payment['sum'];
        }
        $params['receipt']['total'] = (float)$params['receipt']['total'];

        $params['timestamp'] = date('d.m.Y H:i:s');
        return $params;
    }

    public function getReceipt(): array
    {
        return $this->receipt;
    }

    /**
     * @inheritdoc
     */
    public function getRequestUrl()
    {
        return $this->getBaseUrl() . $this->groupCode . '/' . ReceiptOperationTypes::SELL_REFUND;
    }
}