<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProfileResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user' => [
                'name' => $this->users?->name ?? '',
                'email' => $this->users?->email ?? '',
            ],
            // 'user'=>LispostResource::collection($this->users),
            'image'=>$this->image,
        ];
    }
}
