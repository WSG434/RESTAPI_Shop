<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductStatus;
use App\Http\Requests\ApiRequest;
use App\Services\Product\DTO\CreateProductDTO;
use Illuminate\Validation\Rules\Enum;

class StoreProductRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['string'],
            'price' => ['required', 'numeric', 'min:1', 'max:1000000'],
            'count' => ['required', 'int', 'min:0', 'max:1000'],
            'status' => ['required', new Enum(ProductStatus::class)],
            'images.*' => ['image'],
        ];
    }

    public function DTO() : CreateProductDTO
    {
        return CreateProductDTO::from($this->validated());
    }
}
