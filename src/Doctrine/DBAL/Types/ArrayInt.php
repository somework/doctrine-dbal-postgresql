<?php

namespace Opsway\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ArrayInt extends Type
{
    public const ARRAY_INT = 'integer[]';

    public function getName(): string
    {
        return static::ARRAY_INT;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDoctrineTypeMapping(static::ARRAY_INT);
    }

    public function convertToDatabaseValue($array, AbstractPlatform $platform): ?string
    {
        if ($array === null) {
            return null;
        }
        $convertArray = [];
        foreach ($array as $value) {
            if (!is_numeric($value)) {
                continue;
            }
            $convertArray[] = (int)$value;
        }

        return '{'.implode(',', $convertArray).'}';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $value = ltrim(rtrim($value, '}'), '{');
        if ($value === '') {
            return null;
        }
        $r = explode(',', $value);
        foreach ($r as &$v) {
            $v = (int) $v;
        }

        return $r;
    }
}
