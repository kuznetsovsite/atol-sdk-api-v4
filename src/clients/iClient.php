<?php

namespace SaveTime\AtolV4\clients;

use SaveTime\AtolV4\services\BaseServiceRequest;

interface iClient
{

    /**
     * Послать запрос
     * @param BaseServiceRequest $service
     * @return stdClass
     */
    public function sendRequest(BaseServiceRequest $service);
}
