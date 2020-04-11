<?php

namespace SaveTime\AtolV4\DTO;

class Client extends BaseDataObject
{
    protected $email;
    protected $inn;
    protected $name;
    protected $phone;

    /**
     * @param string $email
     * @return self
     */
    public function addEmail($email)
    {
        $this->email = (string)$email;
        return $this;
    }

    /**
     * @param int $inn
     * @return self
     */
    public function addInn($inn)
    {
        $this->inn = (string)$inn;
        return $this;
    }

    /**
     * @param string $name
     * @return self
     */
    public function addName($name)
    {
        $this->name = (string)$name;
        return $this;
    }

    /**
     * @param int $phone Номер телефона в международном формате
     * @return self
     */
    public function addPhone($phone)
    {
        $this->phone = '+' . (string)$phone;
        return $this;
    }
}