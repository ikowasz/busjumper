<?php

namespace App\Service\Timetable\Feeder;

use App\Entity\Timetable\LineStop;
use App\Service\Timetable\Retriever\LineStopRetriever;

class Cache
{
    private const CACHE_KEY_PREFIX = [
        'line_stop' => 'ls',
    ];

    private array $cache = [];

    public function __construct(
        private readonly LineStopRetriever $lineStopRetriever,
    )
    {}

    public function getLineStop(
        string $lineNumber,
        string $directionName,
        string $stopName,
    ): LineStop
    {
        $key = $this->getLineStopCacheKey(
            lineNumber: $lineNumber,
            directionName: $directionName,
            stopName: $stopName,
        );
        $lineStop = $this->getLineStopFromCache($key);

        if (!$lineStop) {
            $lineStop = $this->lineStopRetriever->get(
                lineNumber: $lineNumber,
                directionName: $directionName,
                stopName: $stopName,
            );

            $this->saveLineStopToCache($key, $lineStop);
        }

        return $lineStop;
    }

    private function getLineStopCacheKey(
        string $lineNumber,
        string $directionName,
        string $stopName,
    ): string
    {
        return sprintf(
            '%s-%s-%s-%s',
            self::CACHE_KEY_PREFIX['line_stop'],
            $lineNumber,
            $directionName,
            $stopName,
        );
    }

    private function getLineStopFromCache(string $key): ?LineStop
    {
        return $this->getFromCache($key);
    }

    private function saveLineStopToCache(string $key, LineStop $lineStop): void
    {
        $this->saveToCache($key, $lineStop);
    }

    private function getFromCache(string $key): ?object
    {
        return $this->cache[$key] ?? null;
    }

    private function saveToCache(string $key, object $object): void
    {
        $this->cache[$key] = $object;
    }
}