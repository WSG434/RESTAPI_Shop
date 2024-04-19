<?php

namespace App\Services\Product\DTO;

use App\Enums\ProductStatus;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreateProductDTO extends Data
{
    public string $name;

    #[MapInputName('desc')]
    public string|Optional $description;

    public int|float $price;

    public int $count;

    #[MapInputName('state')]
    public ProductStatus $status;

    public array|Optional $images;
}
