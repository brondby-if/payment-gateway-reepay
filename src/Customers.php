<?php

namespace Brondby\PaymentGateway;

use Brondby\PaymentGateway\Http\Resources\CustomerResource;
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
class Customers
{
    use PaymentGatewayHttpClient;
    use HandleHelper;

    /**
     * Get a single Customer by ID.
     *
     * @param string $customerId Customer ID to get.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function get(string $customerId)
    {
        $this->apiEndPoint = 'customer/'.$this->getCustomerHandle($customerId);
        $this->requestType = 'get';
        $response = $this->performHttpRequest();

        return (new CustomerResource($response))->resolve();
    }

    /**
     * Get list of Customers.
     *
     * @param array $options Options.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function getAll(array $options = [])
    {
        $data = [];
        if (isset($options['page'])) {
            $data['page'] = $options['page'];
        }

        $this->apiEndPoint = 'customer';
        $this->requestType = 'get';
        $this->requestData = $data;
        $responseCustomers = $this->performHttpRequest();

        $customers = [];
        foreach ($responseCustomers['content'] as $customer) {
            array_push($customers, (new CustomerResource($customer))->resolve());
        }

        return $customers;
    }

    /**
     * Create a Customer by ID.
     *
     * @param array $options Options.
     *
     * @return mixed
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function create($customerId, $inputEmail, $inputFirstName, $inputLastName)
    {
        $data = [];
        $data['handle'] = $this->getCustomerHandle($customerId);
        $data['email'] = $inputEmail;
        $data['first_name'] = $inputFirstName;
        $data['last_name'] = $inputLastName;

        $this->apiEndPoint = 'customer';
        $this->requestType = 'post';
        $this->requestData = $data;
        $response = $this->performHttpRequest();

        return isset($response['error']) ? false : (new CustomerResource($response))->resolve();
    }

    /**
     * Get or Create a Customer.
     *
     * @param array $options Options.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function getOrCreate($customerId, $inputEmail, $inputFirstName, $inputLastName)
    {
        $getCustomer = $this->get($customerId);
        if (empty($getCustomer['handle'])) {
            $getCustomer = $this->create($customerId, $inputEmail, $inputFirstName, $inputLastName);
        }

        return $getCustomer;
    }

    /**
     * Update a Customer by ID.
     *
     * Updates the specified customer by setting the values of the parameters passed. Any parameters not provided will be deleted.
     *
     * @return mixed
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function update($customerId, $inputEmail, $inputFirstName, $inputLastName)
    {
        $data = [];
        $data['handle'] = $this->getCustomerHandle($customerId);
        $data['email'] = $inputEmail;
        $data['first_name'] = $inputFirstName;
        $data['last_name'] = $inputLastName;

        $this->apiEndPoint = 'customer/'.$this->getCustomerHandle($customerId);
        $this->requestType = 'put';
        $this->requestData = $data;
        $response = $this->performHttpRequest();

        return isset($response['error']) ? false : (new CustomerResource($response))->resolve();
    }

    /**
     * Create or Update a Customer by ID.
     *
     * @param array $options Options.
     *
     * @return mixed
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function createOrUpdate($customerId, $inputEmail, $inputFirstName, $inputLastName)
    {
        $getCustomer = $this->get($customerId);
        if (empty($getCustomer['handle'])) {
            return $this->create($customerId, $inputEmail, $inputFirstName, $inputLastName);
        }

        return $this->update($customerId, $inputEmail, $inputFirstName, $inputLastName);
    }

    /**
     * Delete a Customer by ID.
     *
     * A customer can only be deleted if it has none or only expired subscriptions, and no pending or dunning invoices.
     *
     * @param string $customerId Customer ID to get.
     *
     * @return boolean
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function delete(string $customerId)
    {
        $this->apiEndPoint = 'customer/'.$this->get($customerId);
        $this->requestType = 'delete';
        $response = $this->performHttpRequest();

        return isset($response['error']) ? false : true;
    }
}
