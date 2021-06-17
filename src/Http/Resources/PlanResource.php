<?php

namespace Brondby\PaymentGateway\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            'name' => $this['name'],
            'vat' => $this['vat'],
            'amount' => $this['amount'],
            'quantity' => $this['quantity'],
            'prepaid' => $this['prepaid'],
            'version' => $this['version'],
            'state' => $this['state'],
            'currency' => $this['currency'],
            'created' => $this['created'],
            'interval_length' => $this['interval_length'],
            'schedule_type' => $this['schedule_type'],
        ];
    }
}
