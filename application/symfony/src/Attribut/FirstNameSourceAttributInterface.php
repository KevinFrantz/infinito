<?php

namespace Infinito\Attribut;

use Infinito\Entity\Source\Primitive\Name\FirstNameSourceInterface;

interface FirstNameSourceAttributInterface
{
    public function getFirstNameSource(): FirstNameSourceInterface;

    public function setFirstNameSource(FirstNameSourceInterface $name): void;
}
