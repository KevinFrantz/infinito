<?php

namespace Infinito\Attribut;

interface TextAttributInterface
{
    public function getText(): string;

    public function setText(string $text): void;
}
