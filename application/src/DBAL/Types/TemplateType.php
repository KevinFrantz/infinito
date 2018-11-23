<?php

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Containes the template types which the system can process.
 *
 * @author kevinfrantz
 */
final class TemplateType extends AbstractEnumType
{
    public const JSON = 'json';

    public const HTML = 'html';

    protected static $choices = [
        self::JSON => 'json',
        self::HTML => 'html',
    ];
}
