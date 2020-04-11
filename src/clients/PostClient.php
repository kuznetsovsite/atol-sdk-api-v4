<?php

namespace SaveTime\AtolV4\clients;

use SaveTime\AtolV4\SdkException;
use SaveTime\AtolV4\services\BaseServiceRequest;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use SaveTime\AtolV4\services\RefundRequest;

class PostClient implements iClient
{

    /** @var int */
    protected $connectionTimeout = 30;
    protected $timeout = 30;
    /** @var int */
    protected $errorCode;
    /** @var string */
    protected $errorDescription;
    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     * @return $this
     */
    public function addLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @param BaseServiceRequest $service
     * @return stdClass
     * @throws SdkException
     */
    public function sendRequest(BaseServiceRequest $service)
    {
        $requestParameters = $service->getParameters();
        $requestUrl = $service->getRequestUrl();
        $headers = $service->getHeaders();

        $curl = curl_init($requestUrl);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if (!empty($requestParameters)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestParameters));
        }
        $response = curl_exec($curl);

        if ($this->logger) {
            $this->logger->log(LogLevel::INFO, 'Requested url ' . $requestUrl . ' params ' . json_encode($requestParameters));
            $this->logger->log(LogLevel::INFO, 'Http headers  ' . print_r($headers, true));
            $this->logger->log(LogLevel::INFO, 'Response ' . $response);
        }

        if (curl_errno($curl)) {
            throw new SdkException(curl_error($curl), curl_errno($curl));
        }

        $decodedResponse = json_decode($response);
        if (empty($decodedResponse)) {
            throw new SdkException('Atol error. Empty response or not json response');
        }

        return $decodedResponse;
    }

    public function setConnectionTimeout(int $connectionTimeout): PostClient
    {
        $this->connectionTimeout = $connectionTimeout;
        return $this;
    }

    public function setTimeout(int $timeout): PostClient
    {
        $this->timeout = $timeout;
        return $this;
    }
}
