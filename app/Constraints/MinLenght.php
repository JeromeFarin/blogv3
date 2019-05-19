<?php

namespace Framework\Constraints;

/**
 * MinLenght class
 * @package Framework\Constraints
 */
class MinLenght implements ConstraintInterface
{
    /**
     * Is min value for lenght
     *
     * @var int
     */
    private $value;

    /**
     * Errors message
     *
     * @var string
     */
    private $message;

    /**
     * Constructor
     *
     * @param integer $value
     * @param string $message
     */
    public function __construct(int $value, string $message) {
        $this->value = $value;
        $this->message = $message;
    }

    /**
     * Check if lenght with min value
     *
     * @param mixed $object
     * @return boolean
     */
    public function valid($object): bool
    {
        if (strlen($object) < $this->value) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Return errors message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
