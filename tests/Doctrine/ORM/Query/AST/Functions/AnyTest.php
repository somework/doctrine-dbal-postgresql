<?php

namespace OpsWay\Tests\Doctrine\ORM\Query\AST\Functions;

use Doctrine\ORM\Query\AST\ParenthesisExpression;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Opsway\Doctrine\ORM\Query\AST\Functions\Any;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class AnyTest extends TestCase
{
    use ProphecyTrait;

    private Any $anyFunction;

    public function setUp(): void
    {
        $this->anyFunction = new Any('test');
    }

    public function testFunction(): void
    {
        $parser = $this->prophesize(Parser::class);
        $expr = $this->prophesize(ParenthesisExpression::class);

        $parser->match()->shouldBeCalled()->withArguments([Lexer::T_IDENTIFIER]);
        $parser->match()->shouldBeCalled()->withArguments([Lexer::T_OPEN_PARENTHESIS]);
        $parser->ArithmeticPrimary()->shouldBeCalled()->willReturn($expr->reveal());
        $parser->match()->shouldBeCalled()->withArguments([Lexer::T_CLOSE_PARENTHESIS]);
        $sqlWalker = $this->prophesize(SqlWalker::class);

        $this->anyFunction->parse($parser->reveal());
        $expr->dispatch()->shouldBeCalled()->withArguments([$sqlWalker->reveal()])->willReturn('test');

        $this->assertEquals('ANY(test)', $this->anyFunction->getSql($sqlWalker->reveal()));
    }
}
