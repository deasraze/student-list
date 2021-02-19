<?php

namespace App\Components\Interfaces;

interface RequestInterface
{
    public function setRequestParams(array $splitRealPath): void;

    public function parsingRouteParams(array $splitRealPath): array;

    public function parsingQueryParams(): array;

    public function parsingPostRequest(): array;

    public function getRequestBody(string $key = null);
}
