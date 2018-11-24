<?php

namespace App\Entity\Attribut;

use Doctrine\Common\Collections\Collection;
use App\Entity\Source\SourceInterface;

/**
 * @author kevinfrantz
 */
interface MembershipsAttributInterface
{
    /**
     * @param Collection|SourceInterface[] $groups
     */
    public function setMemberships(Collection $memberships): void;

    /**
     * @return Collection|SourceInterface[]
     */
    public function getMemberships(): Collection;
}
