<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'role' => $this->role,
            'classYear' => $this->class_year,
            'faculty' => $this->faculty,
            'imageId' => $this->image_id,
            'major' => $this->major,
            'majorCode' => $this->major_code
        ];
    }
}
