<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GudangResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description ?? '-',
            // 'stok_tersedia' => $this->stok_tersedia,
            // 'stok_dipinjam' => $this->stok_dipinjam,
            // 'stok_maintenance' => $this->stok_maintenance,
            'created_at' => $this->created_at,
        ];
    }
}
