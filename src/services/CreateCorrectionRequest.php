<?php

namespace SaveTime\AtolV4\services;

use SaveTime\AtolV4\DTO\Correction;
use SaveTime\AtolV4\DTO\Service;

class CreateCorrectionRequest extends BaseServiceRequest
{

    /** @var Correction */
    protected $correction;
    /** @var string */
    protected $external_id;
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
     * @param Correction $correction
     */
    public function __construct($token, $groupCode, $externalId, Correction $correction)
    {
        $this->token = (string)$token;
        $this->groupCode = $groupCode;
        $this->external_id = (string)$externalId;
        $this->correction = $correction;
    }

    /**
     * @param Service $service
     */
    public function addService(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = parent::getHeaders();
        array_push($headers, 'Token: ' . $this->token);
        return $headers;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $parameters = parent::getParameters();
        $parameters['timestamp'] = date('d.m.Y H:i:s');
        return $parameters;
    }

    /**
     * @inheritdoc
     */
    public function getRequestUrl()
    {
        return $this->getBaseUrl() . $this->groupCode . '/' . $this->correction->getOperationType();
    }
}