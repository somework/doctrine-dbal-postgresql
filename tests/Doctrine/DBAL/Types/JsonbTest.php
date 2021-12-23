<?php

namespace OpsWay\Tests\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Opsway\Doctrine\DBAL\Types\Jsonb;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class JsonbTest extends TestCase
{
    use ProphecyTrait;

    public static function setUpBeforeClass(): void
    {
        Type::addType('jsonb', Jsonb::class);
    }

    public function testGetName(): void
    {
        $jsonb = Jsonb::getType('jsonb');
        $this->assertEquals('jsonb', $jsonb->getName());
    }

    public function testGetSQLDeclaration(): void
    {
        $jsonb = Jsonb::getType('jsonb');
        $platform = $this->prophesize(AbstractPlatform::class);

        $platform->getDoctrineTypeMapping()
            ->shouldBeCalled()
            ->withArguments(['jsonb'])
            ->willReturn('test');

        $this->assertEquals(
            'test',
            $jsonb->getSQLDeclaration([], $platform->reveal())
        );
    }
}
