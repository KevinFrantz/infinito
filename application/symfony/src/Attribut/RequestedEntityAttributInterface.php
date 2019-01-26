<?php

namespace App\Attribut;

use App\Domain\RequestManagement\Entity\RequestedEntityInterface;

/**
 * @author kevinfrantz
 */
interface RequestedEntityAttributInterface
{
    /**
     * @return bool
     */
    public function hasRequestedEntity(): bool;

    /**
     * @return RequestedEntityInterface
     */
    public function getRequestedEntity(): RequestedEntityInterface;

    /**
     * @param RequestedEntityInterface $requestedEntity
     */
    public function setRequestedEntity(RequestedEntityInterface $requestedEntity): void;
}
