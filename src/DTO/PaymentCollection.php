<?php

namespace SaveTime\AtolV4\DTO;

use ArrayAccess;
use Iterator;

class PaymentCollection implements Iterator, ArrayAccess
{
    /** @var Payment[] */
    private $payments = [];
    private $pointer = 0;

    public function __construct(array $payments = [])
    {
        $this->payments = $payments;
    }

    public function addItem(Payment $payment): self
    {
        $this->payments[] = $payment;
        return $this;
    }

    public function current(): ?Payment
    {
        return $this->payments[$this->pointer];
    }

    public function flush(): self
    {
        $this->payments = [];
        $this->pointer = 0;
        return $this;
    }

    public function getSum(): float
    {
        $sum = 0;
        foreach ($this->payments as $payment) {
            // переводим в копейки
            $sum += $payment->getSum() * 100;
        }
        // переводим в рубли
        return (float) $sum / 100;
    }

    public function isEmpty()
    {
        return empty($this->payments);
    }

    public function key(): int
    {
        return $this->pointer;
    }

    public function next(): void
    {
        ++$this->pointer;
    }

    public function offsetExists($offset)
    {
        return isset($this->payments[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->payments[$offset];
    }

    public function offsetSet($offset, $payment)
    {
        if (!$offset) {
            $offset = $this->pointer++;
        }
        $this->setPayment($offset, $payment);
    }

    public function offsetUnset($offset)
    {
        unset($this->payments[$offset]);
    }

    public function rewind(): void
    {
        $this->pointer = 0;
    }

    public function setPayment(int $offset, Payment $payment)
    {
        $this->payments[$offset] = $payment;
    }

    public function valid(): bool
    {
        return isset($this->payments[$this->pointer]);
    }


}
