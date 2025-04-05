<?php

namespace App\DTO\Loader;

class Arrival
{
    public function __construct(
        public readonly Stop $stop,
        public readonly int $hour,
        public readonly int $minute,
    )
    {}
}