<?php

namespace Infinito\Attribut;

use Infinito\Domain\Repository\LayerRepositoryFactoryServiceInterface;

/**
 * @author kevinfrantz
 */
interface LayerRepositoryFactoryServiceAttributInterface
{
    /**
     * @param LayerRepositoryFactoryServiceInterface $layerRepositoryFactoryService
     */
    public function setLayerRepositoryFactoryService(LayerRepositoryFactoryServiceInterface $layerRepositoryFactoryService): void;

    /**
     * @return LayerRepositoryFactoryServiceInterface
     */
    public function getLayerRepositoryFactoryService(): LayerRepositoryFactoryServiceInterface;
}
