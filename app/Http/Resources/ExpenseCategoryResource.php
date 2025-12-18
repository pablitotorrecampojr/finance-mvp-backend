<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseCategoryResource extends JsonResource
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
            'userId' => $this->user_id,
            'category' => $this->category,
            'limit' => $this->limit,
            'limitType' => $this->limit_type,
            'updatedAt' => $this->updated_at,
            'createdAt' => $this->created_at
        ];
    }
}
