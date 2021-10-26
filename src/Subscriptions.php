<?php

namespace Brondby\PaymentGateway;

use Brondby\PaymentGateway\Http\Resources\SubscriptionResource;
use Brondby\PaymentGateway\Traits\HandleHelper;
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
    use HandleHelper;

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

        if (isset($options['status'])) {
            $data['search'] = 'state:'.$options['status'];
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
        $data['search'] = 'customer.handle:'.$this->getCustomerHandle($customerId);
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
     * Change a Subscription to another plan.
     *
     * @return mixed
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function change($subscriptionId, $inputPlan, $inputTiming = 'immediate')
    {
        $data = [];
        $data['handle'] = $subscriptionId;
        $data['plan'] = $inputPlan;
        $data['timing'] = $inputTiming;

        $this->apiEndPoint = 'subscription/'.$subscriptionId;
        $this->requestType = 'put';
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
