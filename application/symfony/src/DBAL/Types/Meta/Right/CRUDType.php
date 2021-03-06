<?php

namespace Infinito\DBAL\Types\Meta\Right;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * @author kevinfrantz
 *
 * @see https://de.wikipedia.org/wiki/CRUD
 */
class CRUDType extends AbstractEnumType
{
    public const CREATE = 'create';

    public const READ = 'read';

    public const UPDATE = 'update';

    public const DELETE = 'delete';

    protected static $choices = [
        self::CREATE => 'create',
        self::READ => 'read',
        self::UPDATE => 'update',
        self::DELETE => 'delete',
    ];
}
