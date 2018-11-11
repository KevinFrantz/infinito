<?php

namespace App\Entity\Attribut;

use App\Entity\Source\Data\Name\FirstNameSourceInterface;

trait FirstNameSourceAttribut
{
    /**
     * @var FirstNameSourceInterface
     */
    protected $firstNameSource;

    public function getFirstNameSource(): FirstNameSourceInterface
    {
        return $this->firstNameSource;
    }

    public function setFirstNameSource(FirstNameSourceInterface $name): void
    {
        $this->firstNameSource = $name;
    }
}