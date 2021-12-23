<?php

namespace OpsWay\Tests\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Opsway\Doctrine\DBAL\Types\TsQuery;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class TsQueryTest extends TestCase
{
    use ProphecyTrait;

    public static function setUpBeforeClass(): void
    {
        Type::addType('tsquery', TsQuery::class);
    }

    public function testGetName(): void
    {
        $tsquery = TsQuery::getType('tsquery');
        $this->assertEquals('tsquery', $tsquery->getName());
    }

    public function testGetSQLDeclaration(): void
    {
        $tsquery = TsQuery::getType('tsquery');
        $platform = $this->prophesize(AbstractPlatform::class);

        $platform->getDoctrineTypeMapping()
            ->shouldBeCalled()
            ->withArguments(['tsquery'])
            ->willReturn('test');

        $this->assertEquals(
            'test',
            $tsquery->getSQLDeclaration([], $platform->reveal())
        );
    }

    public function testConvertToDatabaseValueSQL(): void
    {
        $tsquery = TsQuery::getType('tsquery');
        $platform = $this->prophesize(AbstractPlatform::class);

        $this->assertEquals(
            'plainto_tsquery(test)',
            $tsquery->convertToDatabaseValueSQL('test', $platform->reveal())
        );
    }

    public function testCanRequireSQLConversion(): void
    {
        $tsquery = TsQuery::getType('tsquery');

        $this->assertTrue($tsquery->canRequireSQLConversion());
    }
}
