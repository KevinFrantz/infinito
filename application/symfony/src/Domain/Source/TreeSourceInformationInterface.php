<?php

namespace Infinito\Domain\Source;

use Doctrine\Common\Collections\Collection;

/**
 * Allows to get branches and leaves of a tree.
 *
 * @author kevinfrantz
 */
interface TreeSourceInformationInterface
{
    /**
     * Delivers the branches of the actual tree back.
     */
    public function getBranches(): Collection;

    /**
     * Delivers the members of the actual tree back.
     */
    public function getLeaves(): Collection;

    /**
     * Delivers all members till a infinite level of the tree back.
     */
    public function getAllLeaves(): Collection;

    /**
     * Delivers all branches till a infinite level of the actual tree back.
     */
    public function getAllBranches(): Collection;
}
