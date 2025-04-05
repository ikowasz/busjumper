<?php

namespace App\Service\Http;

use PHPHtmlParser\Contracts\DomInterface;
use PHPHtmlParser\Dom;

class Parse
{
    public function __construct(
        private readonly Fetch $fetch,
    )
    {}

    public function fromUrl(string $url): DomInterface
    {
        $response = $this->fetch->url($url);
        return (new Dom)->loadStr($response);
    }
}