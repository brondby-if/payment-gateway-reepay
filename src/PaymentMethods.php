<?php

namespace Brondby\PaymentGateway;

use Brondby\PaymentGateway\Http\Resources\PaymentMethodResource;
use Brondby\PaymentGateway\Traits\PaymentGatewayHttpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Class PaymentMethods.
 * Handles requests to the Payment Methods endpoints of the Payment Gateway API.
 *
 * @package Brondby\PaymentGateway
 */
class PaymentMethods
{
    use PaymentGatewayHttpClient;

    /**
     * Get a single Payment Method by ID.
     *
     * @param string $paymentMethodId Payment Method ID to get.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function get(string $customerId, string $paymentMethodId)
    {
        $this->apiEndPoint = 'customer/'.$customerId.'/payment_method/card/'.$paymentMethodId;
        $this->requestType = 'get';
        $response = $this->performHttpRequest();

        return $response;

        // todo - add resource

        return (new PaymentMethodResource($response))->resolve();
    }

    /**
     * Get list of Payment Methods by Customer ID.
     *
     * @param array $options Options.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function getByCustomer(string $customerId)
    {
        $this->apiEndPoint = 'customer/'.$customerId.'/payment_method';
        $this->requestType = 'get';
        $responsePaymentMethods = $this->performHttpRequest();

        $paymentMethods = [];
        foreach ($responsePaymentMethods['cards'] as $paymentMethod) {
            array_push($paymentMethods, (new PaymentMethodResource($paymentMethod))->resolve());
        }

        return $paymentMethods;
    }

    /**
     * Get list of Payment Methods by Subscription ID.
     *
     * @param array $subscription Subscription ID.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function getBySubscription(string $subscriptionId)
    {
        $this->apiEndPoint = 'subscription/'.$subscriptionId.'/payment_method';
        $this->requestType = 'get';
        $responsePaymentMethods = $this->performHttpRequest();

        $paymentMethods = [];
        foreach ($responsePaymentMethods['cards'] as $paymentMethod) {
            array_push($paymentMethods, (new PaymentMethodResource($paymentMethod))->resolve());
        }

        return $paymentMethods;
    }

    /**
     * Delete a Payment Method by ID.
     *
     * @param string $customerId Customer ID to get.
     *
     * @return boolean
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function delete(string $customerId, string $paymentMethodId)
    {
        $this->apiEndPoint = 'customer/'.$customerId.'/payment_method/'.$paymentMethodId;
        $this->requestType = 'delete';
        $response = $this->performHttpRequest();

        return isset($response['error']) ? false : true;
    }
}
