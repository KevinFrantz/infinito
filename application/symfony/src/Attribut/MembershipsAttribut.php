<?php

namespace Infinito\Attribut;

use Doctrine\Common\Collections\Collection;
use Infinito\Entity\Meta\Relation\Member\MemberRelationInterface;

/**
 * @author kevinfrantz
 */
trait MembershipsAttribut
{
    /**
     * @var Collection|MemberRelationInterface[]
     */
    protected $memberships;

    /**
     * @return Collection|MemberRelationInterface[]
     */
    public function getMemberships(): Collection
    {
        return $this->memberships;
    }

    /**
     * @param Collection|MemberRelationInterface[] $memberships
     */
    public function setMemberships(Collection $memberships): void
    {
        $this->memberships = $memberships;
    }
}
