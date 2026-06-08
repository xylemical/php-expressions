<?php

/**
 * @file
 */

namespace Xylemical\Expressions;

/**
 * Class Lexer
 *
 * @package Xylemical\Expressions
 */
class Lexer
{

    /**
     * @var \Xylemical\Expressions\ExpressionFactory
     */
    protected $factory;

    /**
     * Lexer constructor.
     *
     * @param \Xylemical\Expressions\ExpressionFactory $factory
     */
    public function __construct(ExpressionFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Converts a string into tokens.
     *
     * @param $string
     *
     * @return \Xylemical\Expressions\Token[]
     *
     * @throws \Xylemical\Expressions\LexerException
     */
    public function tokenize($string)
    {
        // Get the list of sorted operators.
        $operators = $this->factory->getOperators();

        // Get the operator regular expression.
        $regex = $this->getRegex($operators);

        // Break up the string into tokens.
        $matches = preg_split($regex, $string, -1, PREG_SPLIT_DELIM_CAPTURE);
        // Filter whitespace.
        $matches = array_filter(array_map('trim', $matches), 'strlen');
        // Verify expression exists.
        if (count($matches) === 0) {
            throw new LexerException("Invalid expression.");
        }

        // Cycle through all available tokens.
        $tokens = [];
        foreach ($matches as $item) {
            // Process the parentheses as special cases.
            if (in_array($item, ['(', ')', ','])) {
                $tokens[] = new Token($item);
                continue;
            }

            // Locate the first operator that matches the token.
            /** @var \Xylemical\Expressions\Operator $operator */
            foreach ($operators as $operator) {
                if (preg_match('#^' . $operator->getRegex() . '$#i', $item)) {
                    $tokens[] = new Token($item, $operator);
                    continue 2;
                }
            }

            throw new LexerException("Invalid token '" . $item . "'");
        }

        return $tokens;
    }

    /**
     * Get the regex used to locate tokens.
     *
     * @return string
     */
    protected function getRegex($operators)
    {
        $regexes = [];

        /** @var \Xylemical\Expressions\Operator $operator */
        foreach ($operators as $operator)
        {
            $regexes[] = $operator->getRegex();
        }

        // Add parentheses regexes.
        $regexes[] = '\(';
        $regexes[] = '\)';
        $regexes[] = ',';

        // Generate the full regex.
        return '#(' . implode('|', $regexes) . ')#i';
    }
}
