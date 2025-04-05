<?php

namespace App\DTO\Loader;

class DirectedStops
{
    public function __construct(
        public readonly Direction $direction,
        public readonly array $stops,
    )
    {}
}