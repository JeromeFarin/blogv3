<?php

namespace Framework\Constraints;

/**
 * Required class
 * @package Framework\Constraints
 */
class Required implements ConstraintInterface
{
    /**
     * Errors message
     *
     * @var string
     */
    private $message;

    /**
     * Constructor
     *
     * @param string $message
     */
    public function __construct(string $message) {
        $this->message = $message;
    }

    /**
     * Chech if is required
     *
     * @param mixed $object
     * @return boolean
     */
    public function valid($object): bool
    {
        
        if (empty($object) || $object === null) {
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