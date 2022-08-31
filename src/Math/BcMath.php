<?php

/**
 * @file
 */

namespace Xylemical\Expressions\Math;

use Xylemical\Expressions\MathInterface;

/**
 * Class BcMath
 *
 * @package Xylemical\Expressions\Math
 */
class BcMath implements MathInterface
{
    /**
     * @var int
     */
    protected $scale = 0;

    public function __construct($scale = 0)
    {
        $this->scale = (int)$scale;
    }

    /**
     * {@inheritdoc}
     */
    public function add($a, $b, $scale = null) {
        return bcadd($a, $b, $scale ?? $this->scale);
    }

    /**
     * {@inheritdoc}
     */
    public function subtract($a, $b, $scale = null) {
        return bcsub($a, $b, $scale ?? $this->scale);
    }

    /**
     * {@inheritdoc}
     */
    public function multiply($a, $b, $scale = null) {
        return bcmul($a, $b, $scale ?? $this->scale);
    }

    /**
     * {@inheritdoc}
     */
    public function divide($a, $b, $scale = null) {
        return bcdiv($a, $b, $scale ?? $this->scale);
    }

    /**
     * {@inheritdoc}
     */
    public function modulus($a, $b) {
        return bcmod($a, $b);
    }

    /**
     * {@inheritdoc}
     */
    public function compare($a, $b, $scale = null) {
        return bccomp($a, $b, $scale ?? $this->scale);
    }

    /**
     * {@inheritdoc}
     */
    public function native($value) {
        if (strpos($value, '.') !== FALSE) {
            return floatval($value);
        }
        return intval($value);
    }
}
