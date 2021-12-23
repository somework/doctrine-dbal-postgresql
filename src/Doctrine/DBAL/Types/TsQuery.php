<?php

namespace Opsway\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TsQuery extends Type
{
    public const TS_QUERY = 'tsquery';

    public function getName(): string
    {
        return 'tsquery';
    }

    public function canRequireSQLConversion(): bool
    {
        return true;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDoctrineTypeMapping(static::TS_QUERY);
    }

    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform): string
    {
        return sprintf('plainto_tsquery(%s)', $sqlExpr);
    }
}
