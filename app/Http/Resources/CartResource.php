<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,

            'product' => $this->when(
                $this->relationLoaded('product') && $this->product,
                function () {
                    return new ProductResource($this->product);
                }
            ),

            'line_total' => $this->product
                ? round($this->quantity * $this->product->price, 2)
                : 0,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
