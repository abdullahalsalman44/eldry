<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ElderyCollection extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'image' => $this->image,
            'login_at' => $this->login_at,
            'room' => $this->whenLoaded('room'),
        ];
    }
}
