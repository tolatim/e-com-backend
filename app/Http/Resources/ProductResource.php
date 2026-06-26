<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
            'price'       => (float) $this->price,
            'stock'       => $this->stock,
            'image_url'   => $this->image ? asset(Storage::url($this->image)) : null,
            'is_active'   => $this->is_active,
            'category'    => $this->whenLoaded('category', fn () => new CategoryResource($this->category)),
            'created_at'  => $this->created_at,
        ];
    }
}