<?php

namespace OpsWay\Tests\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Opsway\Doctrine\DBAL\Types\ArrayInt;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class ArrayIntTest extends TestCase
{
    use ProphecyTrait;

    public static function setUpBeforeClass(): void
    {
        Type::addType('integer[]', ArrayInt::class);
    }

    public function testGetName(): void
    {
        $arrayInt = ArrayInt::getType('integer[]');
        $this->assertEquals('integer[]', $arrayInt->getName());
    }

    public function testGetSQLDeclaration(): void
    {
        $arrayInt = ArrayInt::getType('integer[]');
        $platform = $this->prophesize(AbstractPlatform::class);

        $platform->getDoctrineTypeMapping()
            ->shouldBeCalled()
            ->withArguments(['integer[]'])
            ->willReturn('test');

        $this->assertEquals(
            'test',
            $arrayInt->getSQLDeclaration([], $platform->reveal())
        );
    }

    public function testConvertToDatabaseValue(): void
    {
        $arrayInt = ArrayInt::getType('integer[]');
        $wrongArray = null;
        $rightArray = [1, 2, 3, 'test'];

        $platform = $this->prophesize(AbstractPlatform::class);

        $this->assertEquals(
            null,
            $arrayInt->convertToDatabaseValue($wrongArray, $platform->reveal())
        );

        $this->assertEquals(
            '{1,2,3}',
            $arrayInt->convertToDatabaseValue($rightArray, $platform->reveal())
        );
    }

    public function testConvertToPHPValue(): void
    {
        $arrayInt = ArrayInt::getType('integer[]');
        $wrongValue = null;
        $secondWrongValue = '{}';
        $rightValue = '{1,2,3}';

        $platform = $this->prophesize(AbstractPlatform::class);

        $this->assertEquals(
            null,
            $arrayInt->convertToPHPValue($wrongValue, $platform->reveal())
        );

        $this->assertEquals(
            null,
            $arrayInt->convertToPHPValue($secondWrongValue, $platform->reveal())
        );

        $this->assertEquals(
            [1, 2, 3],
            $arrayInt->convertToPHPValue($rightValue, $platform->reveal())
        );
    }
}
