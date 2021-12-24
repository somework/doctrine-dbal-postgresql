<?php

namespace Opsway\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class Jsonb extends JsonType
{
    public const JSONB = 'jsonb';

    public function getName(): string
    {
        return static::JSONB;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDoctrineTypeMapping(static::JSONB);
    }

}
