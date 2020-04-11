<?php

namespace SaveTime\AtolV4\services;

class GetTokenRequest extends BaseServiceRequest
{
    /** @var string */
    protected $login;
    /** @var string */
    protected $pass;

    /**
     * Получить токен для сессии
     * @param string $login
     * @param string $password
     */
    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->pass = $password;
    }

    /**
     * @inheritdoc
     */
    public function getRequestUrl()
    {
        return $this->getBaseUrl() . 'getToken';
    }

}
