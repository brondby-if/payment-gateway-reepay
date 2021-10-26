<?php

namespace Brondby\PaymentGateway;

use Brondby\PaymentGateway\Http\Resources\EventResource;
use Brondby\PaymentGateway\Traits\HandleHelper;
use Brondby\PaymentGateway\Traits\PaymentGatewayHttpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Class Events.
 * Handles requests to the Events endpoints of the Payment Gateway API.
 *
 * @package Brondby\PaymentGateway
 */
class Events
{
    use PaymentGatewayHttpClient;
    use HandleHelper;

    /**
     * Get a single Event by ID.
     *
     * @param string $eventId Event ID to get.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function get(string $eventId)
    {
        $this->apiEndPoint = 'event/'.$eventId;
        $this->requestType = 'get';
        $response = $this->performHttpRequest();

        return (new EventResource($response))->resolve();
    }

    /**
     * Get list of all Events.
     *
     * @param array $options Options.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function getAll(array $options = [])
    {
        $data['page'] = $options['page'] ?? 1;
        $data['size'] = $options['size'] ?? 100;
        $this->apiEndPoint = 'event';
        $this->requestType = 'get';
        $this->requestData = $data;
        $responseEvents = $this->performHttpRequest();

        $events = [];
        foreach ($responseEvents['content'] as $event) {
            array_push($events, (new EventResource($event))->resolve());
        }

        $output['data'] = $events;
        $output['page'] = $data['page'];
        $output['per_page'] = $data['size'];

        return $output;
    }

    /**
     * Get list of all Events by Customer ID.
     *
     * @param array $options Options.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function getByCustomer(string $customerId, array $options = [])
    {
        $data['page'] = $options['page'] ?? 1;
        $data['size'] = $options['size'] ?? 100;
        $data['search'] = 'customer.handle:'.$this->getCustomerHandle($customerId);
        $this->apiEndPoint = 'event';
        $this->requestType = 'get';
        $this->requestData = $data;
        $responseEvents = $this->performHttpRequest();

        $events = [];
        foreach ($responseEvents['content'] as $event) {
            array_push($events, (new EventResource($event))->resolve());
        }

        $output['data'] = $events;
        $output['page'] = $data['page'];
        $output['per_page'] = $data['size'];

        return $output;
    }
}
