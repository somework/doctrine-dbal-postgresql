<?php

namespace OpsWay\Tests\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Opsway\Doctrine\DBAL\Types\Citext;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class CitextTest extends TestCase
{
    use ProphecyTrait;

    public static function setUpBeforeClass(): void
    {
        Type::addType('citext', Citext::class);
    }

    public function testGetName(): void
    {
        $citex = Citext::getType('citext');
        $this->assertEquals('citext', $citex->getName());
    }

    public function testGetSQLDeclaration(): void
    {
        $citex = Citext::getType('citext');
        $platform = $this->prophesize(AbstractPlatform::class);

        $platform->getDoctrineTypeMapping()
            ->shouldBeCalled()
            ->withArguments(['citext'])
            ->willReturn('test');

        $this->assertEquals(
            'test',
            $citex->getSQLDeclaration([], $platform->reveal())
        );
    }
}
