<?php

namespace App\Entity\Attribut;

/**
 * @author kevinfrantz
 */
trait IdAttribut
{
    /**
     * @var int
     */
    protected $id;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function hasId(): bool
    {
        return isset($this->id);
    }
}
