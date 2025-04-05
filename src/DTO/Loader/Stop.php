<?php

namespace App\DTO\Loader;

class Stop
{
    public function __construct(
        public readonly Direction $direction,
        public readonly string $name,
        public readonly string $url,
    )
    {}
}