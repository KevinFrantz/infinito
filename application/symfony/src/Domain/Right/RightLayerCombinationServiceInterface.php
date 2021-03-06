<?php

namespace Infinito\Domain\Right;

use Infinito\DBAL\Types\Meta\Right\CRUDType;
use Infinito\DBAL\Types\Meta\Right\LayerType;

/**
 * Allows to get the possible cruds for a layer, or the possible layers for a crud.
 *
 * @author kevinfrantz
 */
interface RightLayerCombinationServiceInterface
{
    /**
     * For layer parameter see:.
     *
     * @see LayerType::getValues()
     *
     * @return array The cruds which exist for a layer
     */
    public function getPossibleCruds(string $layer): array;

    /**
     * For layer parameter see:.
     *
     * @see CRUDType::getValues()
     *
     * @return array The layers which exist for a right
     */
    public function getPossibleLayers(string $crud): array;
}
