<?php

namespace Brondby\PaymentGateway\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @todo make resource file for order line items
     * @return array
     */
    public function toArray($request)
    {
        return [
            'handle' => $this['handle'] ?? null,
            'email' => $this['email'] ?? null,
            'first_name' => $this['first_name'] ?? null,
            'last_name' => $this['last_name'] ?? null,
            'subscriptions' => $this['subscriptions'] ?? 0,
            'active_subscriptions' => $this['active_subscriptions'] ?? 0,
            'created' => $this['created'] ?? null,
            'deleted' => $this['deleted'] ?? null,
        ];
    }
}
