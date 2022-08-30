<?php

/**
 * @file
 */

namespace Xylemical\Expressions;

/**
 * Class MathInterface
 *
 * @package Xylemical\Expressions
 */
interface MathInterface
{

    /**
     * Add $a to $b.
     *
     * @param string $a
     * @param string $b
     * @param int $scale
     *
     * @return string
     */
    public function add($a, $b, $scale = 0);

    /**
     * Subtract $b from $a.
     *
     * @param string $a
     * @param string $b
     * @param int $scale
     *
     * @return string
     */
    public function subtract($a, $b, $scale = 0);

    /**
     * @param string $a
     * @param string $b
     * @param int $scale
     *
     * @return string
     */
    public function multiply($a, $b, $scale = 0);

    /**
     * Divide $a by $b.
     *
     * @param string $a
     * @param string $b
     * @param int $scale
     *
     * @return string
     */
    public function divide($a, $b, $scale = 0);

    /**
     * Get the modulus of $a from $b.
     *
     * @param string $a
     * @param string $b
     *
     * @return string
     */
    public function modulus($a, $b);

    /**
     * Compare $a to $b.
     *
     * @param string $a
     * @param string $b
     * @param int $scale
     *
     * @return int
     */
    public function compare($a, $b, $scale = 0);

    /**
     * Gets the PHP native version of the value.
     *
     * @return int|float
     */
    public function native($value);
}