<?php

namespace App\Service\Timetable;

use App\DTO\Loader\Line;
use App\DTO\Loader\Stop;

abstract class Loader {
    abstract public function getLines(): array;
    abstract public function getLineStops(Line $line): array;
    abstract public function getStopArrivals(Stop $stop): array;
}