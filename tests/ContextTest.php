<?php
/**
 * @file
 */

namespace Xylemical\Expressions;

use PHPUnit\Framework\TestCase;

class ContextTest extends TestCase
{

    /**
     * Test basic crud for context variables.
     */
    public function testCrud()
    {
        $context = new Context();

        $this->assertEquals($context->getVariable('a', 1), 1);

        $context->setVariable('a', 10);
        $this->assertEquals($context->getVariable('a'), 10);
    }
}
