<?php

namespace App\Components\Interfaces;

interface RequestInterface
{
    public function setRequestParams(array $splitRealPath): void;

    public function parsingRequestParams(array $splitRealPath): array;

    public function parsingQueryParams(): array;

    public function parsingPostRequest(): array;

    public function getPostRequest(string $key = null);

    public function getRequestParams(string $key = null);

    public function getQueryParams(string $key = null);
}
