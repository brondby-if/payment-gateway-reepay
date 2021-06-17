<?php

namespace Brondby\PaymentGateway\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'id' => $this['id'],
            'handle' => $this['handle'],
            'customer' => $this['customer'],
            'subscription' => $this['subscription'] ?? null,
            'plan' => $this['plan'] ?? null,
            'plan_version' => $this['plan_version'] ?? null,
            'state' => $this['state'],
            'amount' => $this['amount'],
            'amount_discount_' => $this['discount_amount'],
            'amount_vat' => $this['amount_vat'],
            'amount_ex_vat' => $this['amount_ex_vat'],
            'amount_settled' => $this['settled_amount'],
            'amount_refunded' => $this['refunded_amount'],
            'currency' => $this['currency'],
            'order_lines' => $this['order_lines'],
            'additional_costs' => $this['additional_costs'],
            'transactions' => $this['transactions'],
            'credit_notes' => $this['credit_notes'],
            'due_at' => $this['due'],
            'created_at' => $this['created'],
            'period_from' => $this['period_from'] ?? null,
            'period_to' => $this['period_to'] ?? null,
        ];
    }
}
