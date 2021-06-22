<?php

namespace Brondby\PaymentGateway\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'handle' => $this['handle'],
            'customer' => $this['customer'],
            'plan' => $this['plan'],
            'plan_version' => $this['plan_version'],
            'state' => $this['state'],
            'quantity' => $this['quantity'],
            'created' => $this['created'],
            'activated' => $this['activated'] ?? null,
            'renewing' => $this['renewing'],
            'start_date' => $this['start_date'],
            'current_period_start' => $this['current_period_start'],
            'next_period_start' => $this['next_period_start'],
            'is_cancelled' => $this['is_cancelled'],
            'in_trial' => $this['in_trial'],
            'has_started' => $this['has_started'],
            'renewal_count' => $this['renewal_count'],
            'expired_date' => $this['expired_date'] ?? null,
            'payment_method_added' => $this['payment_method_added'],
            'hosted_page_links' => $this['hosted_page_links'],
        ];
    }
}
