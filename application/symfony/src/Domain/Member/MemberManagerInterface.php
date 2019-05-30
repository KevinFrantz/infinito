<?php

namespace Infinito\Domain\Member;

use Infinito\Entity\Meta\Relation\Member\MemberRelationInterface;

/**
 * @author kevinfrantz
 */
interface MemberManagerInterface
{
    /**
     * @param MemberRelationInterface $member
     */
    public function addMember(MemberRelationInterface $member): void;

    /**
     * @param MemberRelationInterface $member
     */
    public function removeMember(MemberRelationInterface $member): void;

    /**
     * @param MemberRelationInterface $membership
     */
    public function addMembership(MemberRelationInterface $membership): void;

    /**
     * @param MemberRelationInterface $membership
     */
    public function removeMembership(MemberRelationInterface $membership): void;
}