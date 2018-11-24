<?php

namespace App\Entity\Attribut;

use Doctrine\Common\Collections\Collection;
use App\Entity\Source\SourceInterface;

/**
 * @author kevinfrantz
 */
trait MembershipsAttribut
{
    /**
     * @var Collection|SourceInterface[]
     */
    protected $memberships;

    /**
     * @return Collection|SourceInterface[]
     */
    public function getMemberships(): Collection
    {
        return $this->memberships;
    }

    /**
     * @param Collection|SourceInterface[] $memberships
     */
    public function setMemberships(Collection $memberships): void
    {
        $this->memberships = $memberships;
    }
}
