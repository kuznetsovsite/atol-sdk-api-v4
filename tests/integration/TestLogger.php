<?php

namespace SaveTime\AtolV4\tests\integration;

use Psr\Log\LoggerInterface;

class TestLogger implements LoggerInterface
{
    public function alert($message, array $context = [])
    {
        $this->logToFile($message);
    }

    public function critical($message, array $context = [])
    {
        $this->logToFile($message);
    }

    public function debug($message, array $context = [])
    {
        $this->logToFile($message);
    }

    public function emergency($message, array $context = [])
    {
        $this->logToFile($message);
    }

    public function error($message, array $context = [])
    {
        $this->logToFile($message);
    }

    public function info($message, array $context = [])
    {
        $this->logToFile($message);
    }

    public function log($level, $message, array $context = [])
    {
        $this->logToFile($message);
    }

    public function notice($message, array $context = [])
    {
        $this->logToFile($message);
    }

    public function warning($message, array $context = [])
    {
        $this->logToFile($message);
    }

    private function logToFile($message)
    {
        $preparedString = date('Y-m-d H:i:s') . '; ' . $message . PHP_EOL;
        file_put_contents(__DIR__ . '/logs/' . date('Y-m-d') . '.log', $preparedString, FILE_APPEND);
    }
}