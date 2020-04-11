<?php

namespace SaveTime\AtolV4\services;

abstract class CreateDocumentResponse extends BaseServiceResponse
{
    /**
     * @see https://online.atol.ru/files/API_servisa_ATOLOnline_v4.10.pdf part 8.1
     */
    const ERROR_CODE_UNDEFINED = 0;
    const ERROR_CODE_INCOMING_EXTERNAL_ID_ALREADY_EXISTS = 33;

    /** @var string */
    public $status;
    /** @var string Уникальный идентификатор */
    public $uuid;

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'status' => $this->status,
            'uuid' => $this->uuid,
        ]);
    }
}