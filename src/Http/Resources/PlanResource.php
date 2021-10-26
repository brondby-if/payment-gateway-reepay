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
            'id' => $this['handle'],
            'name' => $this['name'],
            'amount' => $this->unitToAmount($this['amount']),
            'version' => $this['version'],
            'status' => $this['state'],
            'currency' => $this['currency'],
            'created' => $this['created'],
            'interval_length' => $this['interval_length'],
            'schedule_type' => $this['schedule_type'],
        ];
    }

    public function unitToAmount($amount)
    {
        return $amount / 100;
    }
}
