<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Published = 'published';
    case Draft = 'draft';
}
