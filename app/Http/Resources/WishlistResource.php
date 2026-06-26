<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'product'    => $this->whenLoaded('product', fn () => new ProductResource($this->product)),
            'created_at' => $this->created_at,
        ];
    }
}