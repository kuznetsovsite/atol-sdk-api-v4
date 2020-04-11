<?php

namespace SaveTime\AtolV4\tests\integration;

use SaveTime\AtolV4\clients\PostClient;
use SaveTime\AtolV4\DTO\AgentInfo;
use SaveTime\AtolV4\DTO\Client;
use SaveTime\AtolV4\DTO\Company;
use SaveTime\AtolV4\DTO\Item;
use SaveTime\AtolV4\DTO\MoneyTransferOperator;
use SaveTime\AtolV4\DTO\PayingAgent;
use SaveTime\AtolV4\DTO\Payment;
use SaveTime\AtolV4\DTO\Receipt;
use SaveTime\AtolV4\DTO\ReceivePaymentsOperator;
use SaveTime\AtolV4\DTO\Supplier;
use SaveTime\AtolV4\DTO\Vat;
use SaveTime\AtolV4\handbooks\AgentTypes;
use SaveTime\AtolV4\handbooks\PaymentMethods;
use SaveTime\AtolV4\handbooks\PaymentObjects;
use SaveTime\AtolV4\handbooks\PaymentTypes;
use SaveTime\AtolV4\handbooks\ReceiptOperationTypes;
use SaveTime\AtolV4\handbooks\SnoTypes;
use SaveTime\AtolV4\handbooks\Vates;
use SaveTime\AtolV4\SdkException;
use SaveTime\AtolV4\services\CreateReceiptRequest;
use SaveTime\AtolV4\services\CreateReceiptResponse;
use SaveTime\AtolV4\services\GetStatusRequest;
use SaveTime\AtolV4\services\GetStatusResponse;
use SaveTime\AtolV4\services\GetTokenRequest;
use SaveTime\AtolV4\services\GetTokenResponse;

class CreateReceiptTest extends IntegrationTestBase
{
    public function testCreateReceipt()
    {
        $client = new PostClient();
        $client->addLogger(new TestLogger());

        $tokenService = $this->createTokenRequest();
        $tokenResponse = new GetTokenResponse($client->sendRequest($tokenService));

        $this->assertTrue($tokenResponse->isValid());

        $createReceiptRequest = $this->createReceiptRequest($tokenResponse->token);
        $createReceiptResponse = new CreateReceiptResponse($client->sendRequest($createReceiptRequest));

        $this->assertTrue($createReceiptResponse->isValid());

        $getStatusRequest = $this->createGetStatusRequest($createReceiptResponse, $tokenResponse);
        if (!$this->checkReceiptStatus($client, $getStatusRequest)) {
            $this->fail('Receipt don`t change status');
        }
    }

    /**
     * @param PostClient $client
     * @param GetStatusRequest $getStatusRequest
     * @return bool
     * @throws SdkException
     */
    private function checkReceiptStatus(PostClient $client, GetStatusRequest $getStatusRequest)
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
     * @return AgentInfo
     */
    private function createAgentInfo()
    {
        $supplier = $this->createSupplier();
        $agentInfo = new AgentInfo(
            new AgentTypes(AgentTypes::PAYING_AGENT),
            $supplier
        );

        $payingAgent = $this->createPayingAgent();
        $agentInfo->addPayingAgent($payingAgent);
        $moneyTransferOperator = $this->createMoneyTransferOperator();
        $receivePaymentOperator = $this->createReceivePaymentOperator();

        $agentInfo->addMoneyTransferOperator($moneyTransferOperator);
        $agentInfo->addReceivePaymentsOperator($receivePaymentOperator);

        return $agentInfo;
    }

    /**
     * @return Company
     */
    private function createCompany()
    {
        $company = new Company(
            'company@test.ru',
            new SnoTypes(SnoTypes::ESN),
            $this->inn,
            $this->paymentAddress
        );
        return $company;
    }

    /**
     * @return Client
     */
    private function createCustomer()
    {
        $customer = new Client();
        $customer->addEmail('test@test.ru');
        $customer->addPhone('79050000000');
        return $customer;
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
     * @return Item
     */
    private function createItem()
    {
        $vat = $this->createVat();
        $item = new Item(
            'Test Product',
            10,
            2,
            $vat
        );
        $agentInfo = $this->createAgentInfo();
        $item->addAgentInfo($agentInfo);
        $item->getPositionSum(20);
        $item->addMeasurementUnit('pounds');
        $item->addPaymentMethod(new PaymentMethods(PaymentMethods::FULL_PAYMENT));
        $item->addPaymentObject(new PaymentObjects(PaymentObjects::COMMODITY));
        $item->addUserData('Test user data');
        return $item;
    }

    /**
     * @return MoneyTransferOperator
     */
    private function createMoneyTransferOperator()
    {
        $moneyTransferOperator = new MoneyTransferOperator('Test moneyTransfer operator');
        $moneyTransferOperator->addInn($this->inn);
        $moneyTransferOperator->addPhone('79050000005');
        $moneyTransferOperator->addAddress('site.ru');
        return $moneyTransferOperator;
    }

    /**
     * @return PayingAgent
     */
    private function createPayingAgent()
    {
        $payingAgent = new PayingAgent('Operation name');
        $payingAgent->addPhone('79050000003');
        $payingAgent->addPhone('79050000004');
        return $payingAgent;
    }

    /**
     * @return Payment
     */
    private function createPayment()
    {
        $payment = new Payment(
            new PaymentTypes(PaymentTypes::ELECTRON),
            20
        );
        return $payment;
    }

    /**
     * @return Receipt
     */
    private function createReceipt()
    {
        $item = $this->createItem();
        $payment = $this->createPayment();
        $customer = $this->createCustomer();
        $company = $this->createCompany();
        $receipt = new Receipt($customer, $company, [$item], $payment, new ReceiptOperationTypes(ReceiptOperationTypes::BUY));
        return $receipt;
    }

    /**
     * @param string $token
     * @return CreateReceiptRequest
     */
    private function createReceiptRequest($token)
    {
        $receipt = $this->createReceipt();
        $externalId = time();
        $createReceiptRequest = new CreateReceiptRequest(
            $token,
            $this->groupCode,
            $externalId,
            $receipt
        );
        $createReceiptRequest->setDevMode();
        return $createReceiptRequest;
    }

    /**
     * @return ReceivePaymentsOperator
     */
    private function createReceivePaymentOperator()
    {
        $receivePaymentOperator = new ReceivePaymentsOperator('79050000006');
        $receivePaymentOperator->addPhone('79050000007');
        return $receivePaymentOperator;
    }

    /**
     * @return Supplier
     */
    private function createSupplier()
    {
        $supplier = new Supplier('Supplier name');
        $supplier->addInn($this->inn);
        $supplier->addPhone('79050000001');
        $supplier->addPhone('79050000002');
        return $supplier;
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
        $vat->addSum(2);
        return $vat;
    }
}
