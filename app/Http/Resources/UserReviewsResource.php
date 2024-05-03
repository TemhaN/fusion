<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserReviewsResource extends JsonResource
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
                'link_img' => $this->film->link_img
            ],
            'message' => $this->message,
            'is_approved' => $this->is_approved,
            'created_at' => $this->created_at,
            'likesCount' => $this->likesCount,
        ];
    }
}