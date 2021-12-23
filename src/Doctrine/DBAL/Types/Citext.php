<?php

namespace Opsway\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class Citext extends TextType
{
    public const CITEXT = 'citext';

    public function getName(): string
    {
        return static::CITEXT;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDoctrineTypeMapping(static::CITEXT);
    }

}
