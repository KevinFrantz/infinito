<?php

namespace Infinito\Attribut;

use Infinito\Entity\Source\Primitive\Name\SurnameSourceInterface;

trait SurnameSourceAttribut
{
    /**
     * @var SurnameSourceInterface
     */
    protected $surnameSource;

    public function getSurnameSource(): SurnameSourceInterface
    {
        return $this->surnameSource;
    }

    public function setSurnameSource(SurnameSourceInterface $name): void
    {
        $this->surnameSource = $name;
    }
}
