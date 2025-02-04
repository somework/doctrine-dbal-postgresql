<?php

namespace Opsway\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ArrayText extends Type
{
    public const ARRAY_TEXT = 'text[]';

    public function getName(): string
    {
        return static::ARRAY_TEXT;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDoctrineTypeMapping(static::ARRAY_TEXT);
    }

    public function convertToDatabaseValue($array, AbstractPlatform $platform): ?string
    {
        if ($array === null) {
            return null;
        }

        $convertArray = [];
        foreach ($array as $value) {
            if ($value === null) {
                $value = 'NULL';
            }
            if ($value === '') {
                $value = '""';
            }

            $convertArray[] = '"' . addcslashes($value, '"') . '"';
        }

        return '{' . implode(',', $convertArray) . '}';
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
        $result = explode(',', $value);

        foreach ($result as $key => $item) {
            $result[$key] = rtrim(ltrim(stripcslashes($item), '"'), '"');

            if ($result[$key] === 'NULL') {
                $result[$key] = null;
            }
        }

        return $result;
    }
}
