<?php

namespace Brondby\PaymentGateway\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResource extends JsonResource
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
            'url' => $this['url'],
        ];
    }
}
