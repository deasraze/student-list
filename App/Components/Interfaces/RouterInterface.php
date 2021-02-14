<?php

namespace App\Components\Interfaces;

interface RouterInterface
{
    public function uriParsing(RequestInterface $request): array;

    public function getSplitRealPath(): array;

    public function getController(): string;

    public function getAction(): string;
}