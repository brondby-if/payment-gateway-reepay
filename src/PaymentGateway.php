<?php

namespace Brondby\PaymentGateway;

use Brondby\PaymentGateway\PaymentGatewayClient;

class PaymentGateway
{
    /**
     * PaymentGateway API client object.
     *
     * @var
     */
    public static $client;

    /**
     * Set PaymentGateway Client.
     *
     * @throws \Exception
     *
     * @return \Brondby\PaymentGateway\PaymentGatewayClient
     */
    public static function setProvider()
    {
        self::$client = new PaymentGatewayClient();

        return self::$client;
    }
}
