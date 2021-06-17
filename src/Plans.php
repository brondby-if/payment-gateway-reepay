<?php

namespace Brondby\PaymentGateway;

use Brondby\PaymentGateway\Http\Resources\PlanResource;
use Brondby\PaymentGateway\Traits\PaymentGatewayHttpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Class Plans.
 * Handles requests to the Customer endpoints of the Payment Gateway API.
 *
 * @package Brondby\PaymentGateway
 */
class Plans
{
    use PaymentGatewayHttpClient;

    /**
     * Get a single Plan by ID.
     *
     * @param string $planId Plan ID to get.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function get(string $planId)
    {
        $this->apiEndPoint = 'plan/'.$planId.'/current';
        $this->requestType = 'get';
        $response = $this->performHttpRequest();

        return (new PlanResource($response))->resolve();
    }

    /**
     * Get list of Plans.
     *
     * @param array $options Options.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function getAll(array $options = [])
    {
        $this->apiEndPoint = 'plan';
        $this->requestType = 'get';
        $responsePlans = $this->performHttpRequest();

        $plans = [];
        foreach ($responsePlans as $plan) {
            array_push($plans, (new PlanResource($plan))->resolve());
        }

        return $plans;
    }

    /**
     * Get all versions for a Plan.
     *
     * @param string $planId Plan ID to get.
     *
     * @return array
     *
     * @throws \Exception Thrown by the HTTP client when there is a problem with the API call.
     */
    public function getVersions(string $planId)
    {
        $this->apiEndPoint = 'plan/'.$planId;
        $this->requestType = 'get';
        $responsePlans = $this->performHttpRequest();

        $plans = [];
        foreach ($responsePlans as $plan) {
            array_push($plans, (new PlanResource($plan))->resolve());
        }

        return $plans;
    }
}
