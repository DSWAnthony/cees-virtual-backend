<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'title'                 => $this->title,
            'description'           => $this->description,
            'image_url'             => $this->image_url,
            'price'                 => $this->price,
            'start_date'            => $this->start_date,
            'end_date'              => $this->end_date,
            'duration_hours'        => $this->duration_hours,
            'is_active'             => $this->is_active,
            'is_published'          => $this->is_published,
            'certificate_enabled'   => $this->certificate_enabled,
            'created_at'            => $this->created_at,
            'techer'                =>  new UserResource($this->whenLoaded('teacher')),
        ];
    }
}
