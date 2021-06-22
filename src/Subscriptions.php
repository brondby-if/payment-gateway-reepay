<?php

namespace Brondby\PaymentGateway;

use Brondby\PaymentGateway\Http\Resources\SubscriptionResource;
use Brondby\PaymentGateway\Traits\PaymentGatewayHttpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Class Customers.
 * Handles requests to the Customer endpoints of the Payment Gateway API.
 *
 * @package Brondby\PaymentGateway
 */
class Subscriptions
{
    use PaymentGatewayHttpClient;

    /**
     * Get a single Subscription by ID.
     *
     * @param string $subscriptionId Subscription ID to get.
     *
     * @return mixed
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function get(string $subscriptionId)
    {
        $this->apiEndPoint = 'subscription/'.$subscriptionId;
        $this->requestType = 'get';
        $response = $this->performHttpRequest();

        return (new SubscriptionResource($response))->resolve();
    }

    /**
     * Get list of Subscriptions.
     *
     * @param array $options Options.
     *
     * @return mixed
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function getAll(array $options = [])
    {
        $data = [];
        if (isset($options['page'])) {
            $data['page'] = $options['page'];
        }

        $this->apiEndPoint = 'subscription';
        $this->requestType = 'get';
        $this->requestData = $data;
        $responseSubscriptions = $this->performHttpRequest();

        $subscriptions = [];
        foreach ($responseSubscriptions['content'] as $subscription) {
            array_push($subscriptions, (new SubscriptionResource($subscription))->resolve());
        }

        return $subscriptions;
    }

    /**
     * Get list of Subscriptions by Customer.
     *
     * @param array $options Options.
     *
     * @return mixed
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function getByCustomer(string $customerId)
    {
        $this->apiEndPoint = 'subscription?search=customer.handle:'.$customerId;
        $this->requestType = 'get';
        $responseSubscriptions = $this->performHttpRequest();

        $subscriptions = [];
        foreach ($responseSubscriptions['content'] as $subscription) {
            array_push($subscriptions, (new SubscriptionResource($subscription))->resolve());
        }

        return $subscriptions;
    }

    /**
     * Create a Subscription.
     *
     * @return mixed
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function create($inputPlan, $inputCustomer)
    {
        $data = [];
        $data['plan'] = $inputPlan;
        $data['customer'] = $inputCustomer;
        $data['generate_handle'] = true;
        $data['conditional_create'] = true;

        $this->apiEndPoint = 'subscription';
        $this->requestType = 'post';
        $this->requestData = $data;
        $response = $this->performHttpRequest();

        return isset($response['error']) ? false : (new SubscriptionResource($response))->resolve();
    }

    /**
     * Cancel a Subscription by ID.
     *
     * @param string $invoiceId Invoice ID to get.
     *
     * @return mixed
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function cancel(string $subscriptionId)
    {
        $data['handle'] = $subscriptionId;
        $this->apiEndPoint = 'subscription/'.$subscriptionId.'/cancel';
        $this->requestType = 'post';
        $this->requestData = $data;
        $response = $this->performHttpRequest();

        return isset($response['error']) ? false : true;
    }

    /**
     * Uncancel a Subscription by ID.
     *
     * @param string $invoiceId Invoice ID to get.
     *
     * @return mixed
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function uncancel(string $subscriptionId)
    {
        $data['handle'] = $subscriptionId;
        $this->apiEndPoint = 'subscription/'.$subscriptionId.'/uncancel';
        $this->requestType = 'post';
        $this->requestData = $data;
        $response = $this->performHttpRequest();

        return isset($response['error']) ? false : true;
    }

    /**
     * Delete a Subscription by ID.
     *
     * @param string $invoiceId Invoice ID to get.
     *
     * @return mixed
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function delete(string $subscriptionId)
    {
        $this->apiEndPoint = 'subscription/'.$subscriptionId;
        $this->requestType = 'delete';
        $response = $this->performHttpRequest();

        return isset($response['error']) ? false : true;
    }
}
