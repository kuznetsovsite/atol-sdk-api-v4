<?php

namespace SaveTime\AtolV4\tests\integration;

use SaveTime\AtolV4\clients\PostClient;
use SaveTime\AtolV4\DTO\Company;
use SaveTime\AtolV4\DTO\Correction;
use SaveTime\AtolV4\DTO\CorrectionInfo;
use SaveTime\AtolV4\DTO\Payment;
use SaveTime\AtolV4\DTO\Vat;
use SaveTime\AtolV4\handbooks\CorrectionOperationTypes;
use SaveTime\AtolV4\handbooks\CorrectionTypes;
use SaveTime\AtolV4\handbooks\PaymentTypes;
use SaveTime\AtolV4\handbooks\SnoTypes;
use SaveTime\AtolV4\handbooks\Vates;
use SaveTime\AtolV4\SdkException;
use SaveTime\AtolV4\services\CreateCorrectionRequest;
use SaveTime\AtolV4\services\CreateReceiptResponse;
use SaveTime\AtolV4\services\GetStatusRequest;
use SaveTime\AtolV4\services\GetStatusResponse;
use SaveTime\AtolV4\services\GetTokenRequest;
use SaveTime\AtolV4\services\GetTokenResponse;

class CreateCorrectionTest extends IntegrationTestBase
{
    public function testCreateCorrection()
    {
        $client = new PostClient();
        $client->addLogger(new TestLogger());

        $tokenService = $this->createTokenRequest();
        $tokenResponse = new GetTokenResponse($client->sendRequest($tokenService));

        $this->assertTrue($tokenResponse->isValid());

        $createReceiptRequest = $this->createCorrectionRequest($tokenResponse->token);
        $createReceiptResponse = new CreateReceiptResponse($client->sendRequest($createReceiptRequest));

        $this->assertTrue($createReceiptResponse->isValid());

        $getStatusRequest = $this->createGetStatusRequest($createReceiptResponse, $tokenResponse);

        if (!$this->checkCorrectionStatus($client, $getStatusRequest)) {
            $this->fail('Correction don`t change status');
        }
    }

    /**
     * @param PostClient $client
     * @param GetStatusRequest $getStatusRequest
     * @return bool
     * @throws SdkException
     */
    private function checkCorrectionStatus(PostClient $client, GetStatusRequest $getStatusRequest)
    {
        for ($second = 0; $second <= 10; $second++) {
            $getStatusResponse = new GetStatusResponse($client->sendRequest($getStatusRequest));
            if ($getStatusResponse->isReceiptReady()) {
                $this->assertTrue($getStatusResponse->isValid());
                return true;
            } else {
                $second++;
            }
            sleep(1);
        }
        return false;
    }

    /**
     * @return Company
     */
    private function createCompany()
    {
        $company = new Company(
            'test@test.ru',
            new SnoTypes(SnoTypes::ESN),
            $this->inn,
            $this->paymentAddress
        );
        return $company;
    }

    /**
     * @return Correction
     */
    private function createCorrection()
    {
        $company = $this->createCompany();
        $correctionInfo = $this->createCorrectionInfo();
        $payment = $this->createPayment();
        $vat = $this->createVat();

        $correction = new Correction(
            new CorrectionOperationTypes(CorrectionOperationTypes::BUY_CORRECTION),
            $company,
            $correctionInfo,
            $payment,
            $vat
        );
        return $correction;
    }

    /**
     * @return CorrectionInfo
     */
    private function createCorrectionInfo()
    {
        $correctionInfo = new CorrectionInfo(
            new CorrectionTypes(CorrectionTypes::SELF),
            new \DateTime(),
            'Test base number',
            'Test base name'
        );
        return $correctionInfo;
    }

    /**
     * @param string $token
     * @return CreateCorrectionRequest
     */
    private function createCorrectionRequest($token)
    {
        $correction = $this->createCorrection();
        $externalId = time();
        $createCorrectionRequest = new CreateCorrectionRequest($token, $this->groupCode, $externalId, $correction);
        $createCorrectionRequest->setDevMode();
        return $createCorrectionRequest;
    }

    /**
     * @param $createReceiptResponse
     * @param $tokenResponse
     * @return GetStatusRequest
     */
    private function createGetStatusRequest($createReceiptResponse, $tokenResponse)
    {
        $getStatusRequest = new GetStatusRequest($this->groupCode, $createReceiptResponse->uuid, $tokenResponse->token);
        $getStatusRequest->setDevMode();
        return $getStatusRequest;
    }

    /**
     * @return Payment
     */
    private function createPayment()
    {
        $payment = new Payment(
            new PaymentTypes(PaymentTypes::ELECTRON),
            100
        );
        return $payment;
    }

    /**
     * @return GetTokenRequest
     */
    private function createTokenRequest()
    {
        $tokenRequest = new GetTokenRequest($this->login, $this->password);
        $tokenRequest->setDevMode();
        return $tokenRequest;
    }

    /**
     * @return Vat
     */
    private function createVat()
    {
        $vat = new Vat(new Vates(Vates::VAT10));
        $vat->addSum(10);
        return $vat;
    }
}