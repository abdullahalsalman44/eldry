<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'target_type' => $this->target_type,
            'eldery' => new ElderyCollection($this->whenLoaded('elderly')),
        ];
    }
}
