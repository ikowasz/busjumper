<?php

namespace App\DTO\Loader;

class Direction
{
    public function __construct(
        public readonly Line $line,
        public readonly string $name,
    )
    {}
}