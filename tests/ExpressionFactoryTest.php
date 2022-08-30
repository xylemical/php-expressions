<?php
/**
 * @file
 */

namespace Xylemical\Expressions;

use PHPUnit\Framework\TestCase;
use Xylemical\Expressions\Math\BcMath;

class ExpressionFactoryTest extends TestCase
{
    /**
     * @var \Xylemical\Expressions\Parser
     */
    protected $parser;

    /**
     * @var \Xylemical\Expressions\Evaluator
     */
    protected $evaluator;

    /**
     * @var
     */
    protected $context;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $math = new BcMath();
        $factory = new ExpressionFactory($math);

        // Add in variable processor for lexing.
        $factory->addOperator(new Value('\$[a-zA-Z_][a-zA-Z0-9_]*', function(array $operands, Context $context, Token $token) {
            return $context->getVariable(substr($token->getValue(), 1));
        }));

        $lexer = new Lexer($factory);;
        $this->parser = new Parser($lexer);

        $this->evaluator = new Evaluator();

        $this->context = new Context;
    }

    /**
     * Test the plus operation.
     */
    public function testPlus() {
        $tokens = $this->parser->parse('1 + 1');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('2', $result);
    }

    /**
     * Test the subtract operation.
     */
    public function testSubtract() {
        $tokens = $this->parser->parse('1 - 1');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);
    }

    /**
     * Test the multiply operation.
     */
    public function testMultiply() {
        $tokens = $this->parser->parse('1 * 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('2', $result);
    }

    /**
     * Test the divide operation.
     */
    public function testDivide() {
        $tokens = $this->parser->parse('4 / 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('2', $result);
    }

    /**
     * Test the modulus operation.
     */
    public function testModulus() {
        $tokens = $this->parser->parse('3 % 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);
    }

    /**
     * Test the equals operation.
     */
    public function testEquals() {
        $tokens = $this->parser->parse('2 == 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);
        
        $tokens = $this->parser->parse('2 == 3');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);
        
        $tokens = $this->parser->parse('3 == 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);
    }

    /**
     * Test the lessThan operation.
     */
    public function testLessThan() {
        $tokens = $this->parser->parse('2 < 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);

        $tokens = $this->parser->parse('2 < 3');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);

        $tokens = $this->parser->parse('3 < 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);
    }

    /**
     * Test the lessThanEquals operation.
     */
    public function testLessThanEquals() {
        $tokens = $this->parser->parse('2 <= 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);

        $tokens = $this->parser->parse('2 <= 3');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);

        $tokens = $this->parser->parse('3 <= 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);
    }

    /**
     * Test the greaterThan operation.
     */
    public function testGreaterThan() {
        $tokens = $this->parser->parse('2 > 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);

        $tokens = $this->parser->parse('2 > 3');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);

        $tokens = $this->parser->parse('3 > 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);
    }

    /**
     * Test the greaterThanEquals operation.
     */
    public function testGreaterThanEquals() {
        $tokens = $this->parser->parse('2 >= 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);

        $tokens = $this->parser->parse('2 >= 3');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);

        $tokens = $this->parser->parse('3 >= 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);
    }

    /**
     * Test the notEquals operation.
     */
    public function testNotEquals() {
        $tokens = $this->parser->parse('2 != 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);

        $tokens = $this->parser->parse('2 != 3.5');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);

        $tokens = $this->parser->parse('3 != 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);
    }

    /**
     * Test the and operation.
     */
    public function testAnd() {
        $tokens = $this->parser->parse('2 AND 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);

        $tokens = $this->parser->parse('2 AND 0');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);

        $tokens = $this->parser->parse('0 AND 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);

        $tokens = $this->parser->parse('0 AND 0');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);
    }

    /**
     * Test the or operation.
     */
    public function testOr() {
        $tokens = $this->parser->parse('2 OR 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);

        $tokens = $this->parser->parse('2 OR 0');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);

        $tokens = $this->parser->parse('0 OR 2');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);

        $tokens = $this->parser->parse('0 OR 0');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);
    }

    /**
     * Test the not operation.
     */
    public function testNot() {
        $tokens = $this->parser->parse('NOT(2.5)');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);

        $tokens = $this->parser->parse('NOT(0)');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('1', $result);
    }

    /**
     * Test the min operation.
     */
    public function testMin() {
        $tokens = $this->parser->parse('MIN(2, 0)');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);

        $tokens = $this->parser->parse('MIN(0, 2)');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('0', $result);
    }

    /**
     * Test the max operation.
     */
    public function testMax() {
        $tokens = $this->parser->parse('MAX(2, 0)');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('2', $result);

        $tokens = $this->parser->parse('MAX(0, 2)');

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals('2', $result);
    }

    /**
     * @dataProvider getScaleTestData
     */
    public function testScalePropertyIsApplied($scale, $expression, $expected)
    {
        $math = new BcMath($scale);
        $factory = new ExpressionFactory($math);

        $lexer = new Lexer($factory);;
        $parser = new Parser($lexer);

        $tokens = $parser->parse($expression);

        $result = $this->evaluator->evaluate($tokens, $this->context);

        $this->assertEquals($expected, $result);
    }

    public function getScaleTestData()
    {
        return [
            'multiplication' => [
                'scale' => 3,
                'expression' => '1.005 * 2',
                'expected' => '2.010',
            ],
            'division' => [
                'scale' => 4,
                'expression' => '1.005 / 2',
                'expected' => '0.5025',
            ],
            'division with reduced scale' => [
                'scale' => 3,
                'expression' => '1.005 / 2',
                'expected' => '0.502',
            ],
            'addition' => [
                'scale' => 5,
                'expression' => '1.005 + 2',
                'expected' => '3.00500',
            ],
            'subtraction' => [
                'scale' => 3,
                'expression' => '1.005 - 2',
                'expected' => '-0.995',
            ],
        ];
    }
}
