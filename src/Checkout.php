<?php

namespace Brondby\PaymentGateway;

use Brondby\PaymentGateway\Http\Resources\CheckoutResource;
use Brondby\PaymentGateway\Traits\PaymentGatewayHttpClient;
use Illuminate\Support\Facades\Http;

/**
 * Class Checkout.
 * Handles requests to the checkout endpoints of the Payment Gateway API.
 *
 * @package Brondby\PaymentGateway
 */
class Checkout
{
    use PaymentGatewayHttpClient;

    /**
     * Create a Payment Window Session.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function createPaymentWindow($inputCustomer, $inputOrderText = null, $inputButtonText = null, $inputAcceptUrl, $inputCancelUrl)
    {
        $data = [];
        $data['customer'] = $inputCustomer;
        $data['order_text'] = $inputOrderText;
        $data['button_text'] = $inputButtonText;
        $data['accept_url'] = $inputAcceptUrl;
        $data['cancel_url'] = $inputCancelUrl;

        $this->apiUrl = 'https://checkout-api.reepay.com/v1/';
        $this->apiEndPoint = 'session/recurring';
        $this->requestType = 'post';
        $this->requestData = $data;
        $response = $this->performHttpRequest();

        return (new CheckoutResource($response))->resolve();
    }

    /**
     * Create a Payment Window Session.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function createNewSubscription($inputCustomer, $inputPlan, $inputAcceptUrl, $inputCancelUrl)
    {
        $data = [];
        $data['prepare_subscription']['customer'] = $inputCustomer;
        $data['prepare_subscription']['plan'] = $inputPlan;
        $data['prepare_subscription']['generate_handle'] = true;
        $data['prepare_subscription']['no_trial'] = true;
        $data['show_subscription_details'] = true;
        $data['accept_url'] = $inputAcceptUrl;
        $data['cancel_url'] = $inputCancelUrl;

        $this->apiUrl = 'https://checkout-api.reepay.com/v1/';
        $this->apiEndPoint = 'session/subscription';
        $this->requestType = 'post';
        $this->requestData = $data;
        $response = $this->performHttpRequest();

        return (new CheckoutResource($response))->resolve();
    }

    /**
     * Create a Payment Window Session.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function updateSubscription($inputSubscription, $inputAcceptUrl, $inputCancelUrl)
    {
        $data = [];
        $data['subscription'] = $inputSubscription;
        $data['show_subscription_details'] = true;
        $data['accept_url'] = $inputAcceptUrl;
        $data['cancel_url'] = $inputCancelUrl;

        $this->apiUrl = 'https://checkout-api.reepay.com/v1/';
        $this->apiEndPoint = 'session/subscription';
        $this->requestType = 'post';
        $this->requestData = $data;
        $response = $this->performHttpRequest();

        return (new CheckoutResource($response))->resolve();
    }
}
