<?php

namespace Brondby\PaymentGateway;

use Brondby\PaymentGateway\Http\Resources\InvoiceResource;
use Brondby\PaymentGateway\Traits\PaymentGatewayHttpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Class Invoices.
 * Handles requests to the Invoices endpoints of the Payment Gateway API.
 *
 * @package Brondby\PaymentGateway
 */
class Invoices
{
    use PaymentGatewayHttpClient;

    /**
     * Get a single Invoice by ID.
     *
     * @param string $invoiceId Invoice ID to get.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function get(string $invoiceId)
    {
        $this->apiEndPoint = 'invoice/'.$invoiceId;
        $this->requestType = 'get';
        $response = $this->performHttpRequest();

        return (new InvoiceResource($response))->resolve();
    }

    /**
     * Get list of all Invoices.
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

        $this->apiEndPoint = 'invoice';
        $this->requestType = 'get';
        $this->requestData = $data;
        $responseInvoices = $this->performHttpRequest();

        $invoices = [];
        foreach ($responseInvoices['content'] as $invoice) {
            array_push($invoices, (new InvoiceResource($invoice))->resolve());
        }

        return $invoices;
    }

    /**
     * Get list of all Invoices by Customer ID.
     *
     * @param array $options Options.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function getByCustomer(string $customerId)
    {
        $data['search'] = 'customer.handle:'.$customerId;
        $this->apiEndPoint = 'invoice';
        $this->requestType = 'get';
        $this->requestData = $data;
        $responseInvoices = $this->performHttpRequest();

        $invoices = [];
        foreach ($responseInvoices['content'] as $invoice) {
            array_push($invoices, (new InvoiceResource($invoice))->resolve());
        }

        return $invoices;
    }

    /**
     * Cancel an Invoice by ID.
     *
     * @param string $invoiceId Invoice ID to get.
     *
     * @return boolean
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function cancel(string $invoiceId)
    {
        $this->apiEndPoint = 'invoice/'.$invoiceId.'/cancel';
        $this->requestType = 'post';
        $response = $this->performHttpRequest();

        return isset($response['error']) ? false : true;
    }

    /**
     * Reactivate an Invoice by ID.
     *
     * @param string $invoiceId Invoice ID to get.
     *
     * @return boolean
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function reactivate(string $invoiceId)
    {
        $this->apiEndPoint = 'invoice/'.$invoiceId.'/reactivate';
        $this->requestType = 'post';
        $response = $this->performHttpRequest();

        return isset($response['error']) ? false : true;
    }
}
