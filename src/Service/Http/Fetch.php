<?php

namespace App\Service\Http;

use Psr\Log\LoggerInterface;


class Fetch
{
    public function __construct(
        private readonly LoggerInterface $logger,
    )
    {}


    public function url(string $url): string
    {
        $this->logger->info("Fetching URL: $url");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);

        $this->logger->info("Done fetching!");
        return $response;
    }
}