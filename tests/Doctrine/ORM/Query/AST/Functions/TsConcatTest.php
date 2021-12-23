<?php

namespace OpsWay\Tests\Doctrine\ORM\Query\AST\Functions;

use Opsway\Doctrine\ORM\Query\AST\Functions\TsConcat;
use OpsWay\Tests\EmTestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class TsConcatTest extends EmTestCase
{
    use ProphecyTrait;

    protected function customStringFunctions(): array
    {
        return [
            'TS_CONCAT_OP' => TsConcat::class,
        ];
    }

    /** @dataProvider functionData */
    public function testFunction(string $dql, string $sql): void
    {
        $query = $this->em->createQuery($dql);
        $this->assertEquals($sql, $query->getSql());
    }

    public function functionData(): array
    {
        return [
            [
                'SELECT TS_CONCAT_OP(e.id, e.id) FROM OpsWay\Tests\Entity e',
                'SELECT e0_.id || e0_.id AS sclr_0 FROM Entity e0_',
            ],
            [
                'SELECT TS_CONCAT_OP(e.id, e.id, e.id) FROM OpsWay\Tests\Entity e',
                'SELECT e0_.id || e0_.id || e0_.id AS sclr_0 FROM Entity e0_',
            ],
        ];
    }
}

