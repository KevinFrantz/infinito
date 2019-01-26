<?php

namespace App\Attribut;

use App\Domain\RequestManagement\Right\RequestedRightInterface;

/**
 * @author kevinfrantz
 */
interface RequestedRightAttributInterface
{
    /**
     * @param RequestedRightInterface $requestedRight
     */
    public function setRequestedRight(RequestedRightInterface $requestedRight): void;

    /**
     * @return RequestedRightInterface
     */
    public function getRequestedRight(): RequestedRightInterface;
}
