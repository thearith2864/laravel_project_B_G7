<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LisCommentPostedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user_comment" => new LisUserPostedResource($this->user),
            "Comment" => $this->comment,
            "date_comment" => $this->updated_at -> format('Y-m-d H:i:s'),
        ];
    }
}
