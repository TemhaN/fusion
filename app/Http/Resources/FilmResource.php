<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
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
            'name' => $this->name,
            'duration' => $this->duration,
            'year_of_issue' => $this->year_of_issue,
            'age' => $this->age,
            'link_img' => $this->link_img,
            'link_kinopoisk' => $this->link_kinopoisk,
            'link_video' => $this->link_video,
            'created_at' => new Carbon($this->created_at),
            'country' => $this->country,
            'categories' =>$this->categories ?
                CategoryBasicResource::collection($this->categories) : null,
            'ratingAvg' => round($this->ratings()->avg('ball'), 1),
            'reviewCount' => $this->reviews()->count(),
            // 'favoriteCount' => $this->favorites()->count(),
        ];
    }
}