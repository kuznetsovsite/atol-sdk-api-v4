<?php

namespace SaveTime\AtolV4\tests\integration;

class IntegrationTestBase extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    protected $groupCode;
    /** @var int */
    protected $inn;
    /** @var string */
    protected $login;
    /** @var string */
    protected $password;
    /** @var string */
    protected $paymentAddress;

    public function __construct()
    {
        $this->login = MerchantSettings::LOGIN;
        $this->password = MerchantSettings::PASSWORD;
        $this->inn = MerchantSettings::INN;
        $this->groupCode = MerchantSettings::GROUP_ID;
        $this->paymentAddress = MerchantSettings::PAYMENT_ADDRESS;
    }
}
