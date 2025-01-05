<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'productId' => $this->id,
            'attributes' =>[
                'productName' => $this->pro_name,
                'description' => $this->pro_description,
                'price' => $this->pro_price,
                'productMainCategory' => $this->pro_maincategory,
                'productCategory' => $this->pro_category,
                'brandId' => $this->brand_id,
            ],
            'mainCategroy' => [
                'id' => $this->mainCategory->id,
                'Name' => $this->mainCategory->mcate_name,
            ],
            'Category' => [
                'id' => $this->category->id,
                'Name' => $this->category->cate_name
            ],
            'brand' => [
                'id' => $this->brand->id,
                'Name' => $this->brand->name
            ]
        ];
    }
}
