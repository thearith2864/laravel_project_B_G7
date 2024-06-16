<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LispostResource extends JsonResource
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
            'User_posted' => new LisUserPostedResource($this->user),
            'Title' => $this->title,
            'image' => "http://127.0.0.1:8000".$this->media->image,
            "date_Post" => $this->updated_at -> format('Y-m-d H:i:s'),
            'Comments' => LisCommentPostedResource::collection($this->comment),
            'total_Comments' => $this->comment -> count(),
            'Reactions' => LisReactPostedResource::collection($this->reaction)   ,
            'total_Reactions' => $this->reaction -> count()
        ];
    }
}
