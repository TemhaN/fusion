<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRatingResource extends JsonResource
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
            'film' => [
                'id' => $this->film->id,
                'name' => $this->film->name,
            ],
            'score' => $this->ball,
            'created_at' => $this->created_at,
        ];
    }
}
