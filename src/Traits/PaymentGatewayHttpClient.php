<?php

namespace Brondby\PaymentGateway\Traits;

use Brondby\PaymentGateway\Traits\PaymentGatewayHttpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

trait PaymentGatewayHttpClient
{
    /**
     * API Endpoint.
     *
     * @var string
     */
    private $apiUrl = 'https://api.reepay.com/v1/';

    /**
     * API Endpoint.
     *
     * @var string
     */
    private $apiEndPoint = '';

    /**
     * Request type.
     *
     * @var string
     */
    protected $requestType = 'get';

    /**
     * Request data parameters.
     *
     * @var array
     */
    protected $requestData = [];

    /**
     * Perform Payment Gateway API Request.
     *
     * @param bool $decode
     *
     * @throws \Throwable
     *
     * @return array|string
     */
    private function performHttpRequest($decode = true)
    {
        try {
            $response = Http::acceptJson()->withHeaders([
                'Authorization' => 'Basic '.config('payment-gateway.key')
            ])->{$this->requestType}($this->apiUrl.$this->apiEndPoint, $this->requestData);

            return ($decode === false) ? $response : $response->json();

        } catch (ClientException $e) {
            throw new RuntimeException($e->getResponse()->getBody());
        }
    }
}
