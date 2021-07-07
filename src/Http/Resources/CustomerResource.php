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
            'email' => $this['email'],
            'handle' => $this['handle'],
            'first_name' => $this['first_name'],
            'last_name' => $this['last_name'],
            'subscriptions' => $this['subscriptions'],
            'active_subscriptions' => $this['active_subscriptions'],
            'created' => $this['created'],
        ];
    }
}
