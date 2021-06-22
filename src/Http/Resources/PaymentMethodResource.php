<?php

namespace Brondby\PaymentGateway\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
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
            'id' => $this['id'],
            'state' => $this['state'],
            'customer' => $this['customer'],
            'created_at' => $this['created'],
            'fingerprint' => $this['fingerprint'],
            'gw_ref' => $this['gw_ref'],
            'type' => $this['card_type'],
            'exp_date' => $this['exp_date'],
            'last_four' => mb_substr($this['masked_card'], -4),
            'country' => $this['card_country'],
        ];
    }
}
