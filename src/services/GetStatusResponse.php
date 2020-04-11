<?php

namespace SaveTime\AtolV4\services;

use stdClass;

class GetStatusResponse extends BaseServiceResponse
{

    const STATUS_DONE = 'done';
    /** @var string */
    public $ecr_registration_number;
    /** @var int */
    public $fiscal_document_attribute;
    /** @var int */
    public $fiscal_document_number;
    /** @var int */
    public $fiscal_receipt_number;
    /** @var int */
    public $fn_number;
    /** @var string */
    public $receipt_datetime;
    /** @var int */
    public $shift_number;
    /** @var string */
    public $status;
    /** @var float */
    public $total;

    /**
     * @inheritdoc
     */
    public function __construct(stdClass $response)
    {
        if ($response->status == self::STATUS_DONE) {
            $this->status = self::STATUS_DONE;
            parent::__construct($response->payload);
        } else {
            $this->status = $response->status;
            parent::__construct($response);
        }
    }

    /**
     * Создан ли уже чек
     * @return boolean
     */
    public function isReceiptReady()
    {
        return $this->status == self::STATUS_DONE;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'ecr_registration_number' => $this->ecr_registration_number,
            'fiscal_document_attribute' => $this->fiscal_document_attribute,
            'fiscal_document_number' => $this->fiscal_document_number,
            'fiscal_receipt_number' => $this->fiscal_receipt_number,
            'fn_number' => $this->fn_number,
            'receipt_datetime' => $this->receipt_datetime,
            'shift_number' => $this->shift_number,
            'status' => $this->status,
            'total' => $this->total,
        ]);
    }
}
