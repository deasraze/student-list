<?php

namespace App\Components\Interfaces;

interface RouterInterface
{
    public function getSplitRealPath(): array;

    public function getController(): string;

    public function getAction(): string;
}
