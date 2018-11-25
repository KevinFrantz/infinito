<?php

namespace App\Entity\Meta;

use App\Entity\EntityInterface;
use App\Entity\Attribut\SourceAttributInterface;

/**
 * Meta entities contain informations which describe sources.
 * If you refer from a meta entity to an source be aware to catch infinite loops!
 *
 * @author kevinfrantz
 */
interface MetaInterface extends EntityInterface, SourceAttributInterface
{
}
