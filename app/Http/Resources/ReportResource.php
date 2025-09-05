<?php

namespace App\Http\Resources;

use App\Filament\Resources\ElderlyPersonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'apetitie' => $this->apetitie,
            'mood' => $this->mood,
            'health' => $this->health,
            'sleep_rate' => $this->sleep_rate,
            'eldery_id' => new ElderlyPersonResource($this->whenLoaded('eldery')),
            'caregiver_id' => new UserResource($this->whenLoaded('caregiver')),
        ];
    }
}
