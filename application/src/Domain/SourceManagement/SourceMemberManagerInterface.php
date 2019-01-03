<?php

namespace App\Domain\SourceManagement;

use App\Entity\Source\SourceInterface;

interface SourceMemberManagerInterface
{
    /**
     * @param SourceInterface $member
     */
    public function addMember(SourceInterface $member): void;

    /**
     * @param SourceInterface $member
     */
    public function removeMember(SourceInterface $member): void;

    /**
     * @param SourceInterface $membership
     */
    public function addMembership(SourceInterface $membership): void;

    /**
     * @param SourceInterface $membership
     */
    public function removeMembership(SourceInterface $membership): void;
}