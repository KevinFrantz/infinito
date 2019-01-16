<?php

namespace App\Domain\RequestManagement;

use App\Entity\Attribut\CrudAttributInterface;
use App\Entity\Attribut\RecieverAttributInterface;
use App\Entity\Attribut\LayerAttributInterface;
use App\Entity\Source\SourceInterface;

/**
 * @author kevinfrantz
 */
interface RequestedRightInterface extends CrudAttributInterface, RecieverAttributInterface, LayerAttributInterface
{
    /**
     * @param RequestedSourceInterface $requestedSource
     */
    public function setRequestedSource(RequestedSourceInterface $requestedSource);

    /**
     * {@inheritdoc}
     *
     * @see \App\Entity\Attribut\SourceAttributInterface::getSource()
     */
    public function getSource(): SourceInterface;
}
