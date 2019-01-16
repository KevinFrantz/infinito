<?php

namespace App\Entity\Attribut;

/**
 * @author kevinfrantz
 */
interface CrudAttributInterface
{
    public function setCrud(string $crud): void;

    public function getCrud(): string;
}
