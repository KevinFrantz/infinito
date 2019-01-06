<?php

namespace App\DBAL\Types\Meta\Right;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * @author kevinfrantz
 */
final class LayerType extends AbstractEnumType
{
    public const HEREDITY = 'heredity';

    public const RIGHT = 'right';

    public const SOURCE = 'source';

    public const LAW = 'law';

    public const MEMBER = 'member';

    /**
     * @var array Ordered by the importants of implementation
     */
    protected static $choices = [
        self::SOURCE => 'source',
        self::LAW => 'law',
        self::RIGHT => 'right',
        self::MEMBER => 'member',
        self::HEREDITY => 'heredity',
    ];
}