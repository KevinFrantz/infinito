<?php

namespace Infinito\Attribut;

/**
 * @author kevinfrantz
 *
 * @see TextAttributInterface
 */
trait TextAttribut
{
    /**
     * @var string
     */
    protected $text;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
}
