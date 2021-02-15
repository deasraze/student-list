<?php

namespace App\Components\Interfaces;

interface RendererInterface
{
    public function render(string $template, array $args): string;
}