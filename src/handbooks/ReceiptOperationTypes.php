<?php

namespace SaveTime\AtolV4\handbooks;

use MyCLabs\Enum\Enum;

class ReceiptOperationTypes extends Enum
{
    const
        SELL = 'sell',
        SELL_REFUND = 'sell_refund',
        BUY = 'buy',
        BUY_REFUND = 'buy_refund';
}