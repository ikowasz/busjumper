<?php

namespace App\DTO\Loader;

class Line
{
    public function __construct(
        public readonly string $number,
        public readonly string $url,
    )
    {}
}