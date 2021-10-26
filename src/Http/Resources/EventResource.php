<?php

namespace Brondby\PaymentGateway\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'id' => $this['id'] ?? null,
            'customer' => $this['customer'] ?? null,
            'created_at' => Carbon::parse($this['created']),
            'type' => $this['event_type'],
            'object' => $this->getObjectFromType($this['event_type']),
            'object_id' => $this[$this->getObjectFromType($this['event_type'])] ?? null,
        ];
    }

    /**
     * Get object name based on the event type.
     *
     * @param  string $type
     * @return string
     */
    public function getObjectFromType($type)
    {
        $type = explode('_', $type);

        return $type[0] ?? 'Unknown';
    }
}
