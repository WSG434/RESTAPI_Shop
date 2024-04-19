<?php

namespace App\Exceptions\Product;

use Exception;

class ProductNotFoundException extends Exception
{
    public function __construct(string $message = null, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message ?? getMessage('product_not_found'), $code, $previous);
    }
}
