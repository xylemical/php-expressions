<?php

/**
 * @file
 */

namespace Xylemical\Expressions;

/**
 * Class Context
 *
 * @package Xylemical\Expressions
 */
class Context
{

    /**
     * The internal variables used by tasks.
     *
     * @var array
     */
    protected $variables = [];

    /**
     * Get a variable by name, with default support.
     *
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function getVariable($name, $default = null)
    {
        if (!array_key_exists($name, $this->variables)) {
            return $default;
        }
        return $this->variables[$name];
    }

    /**
     * Set a variable value by name.
     *
     * @param string $name
     * @param mixed $value
     *
     * @return static
     */
    public function setVariable($name, $value)
    {
        $this->variables[$name] = $value;
        return $this;
    }
}
