<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandRresource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "brandId" => $this->id,
            "attributes" => [
                "brandName" => $this->name,
                "brandAddress" => $this->address,
                "brandLogo" => url("/storage/" .$this->logo_path),
            ],
            "user" => [
                "userId" => $this->user->id,
                "userName" => $this->user->name,
                "userEmail" => $this->user->email,
            ],
        ];
    }
}
