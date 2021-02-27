<?php

namespace App\Components\Interfaces;

interface RequestInterface
{
    public function setRequestBody(array $splitRealPath): void;

    public function getRequestBody(string $key = null, $default = null);

    public function getRequestUri(): string;

    public function getUrlPath(): string;
}
