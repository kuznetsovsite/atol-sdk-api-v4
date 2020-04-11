<?php

namespace SaveTime\AtolV4\services;

use SaveTime\AtolV4\DTO\BaseDataObject;

abstract class BaseServiceRequest extends BaseDataObject
{
    const
        REQUEST_URL = 'https://online.atol.ru/possystem/v4/',
        REQUEST_DEMO_URL = 'https://testonline.atol.ru/possystem/v4/';
    /** @var bool */
    private $devMode = false;

    /**
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Content-type: application/json; charset=utf-8',
        ];
    }

    /**
     * Получить url ждя запроса
     * @return string
     */
    abstract public function getRequestUrl();

    public function setDevMode(bool $value = true)
    {
        $this->devMode = $value;
        return $this;
    }

    /**
     * @return string
     */
    protected function getBaseUrl()
    {
        return $this->devMode ? self::REQUEST_DEMO_URL : self::REQUEST_URL;
    }
}
