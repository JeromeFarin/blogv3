<?php

namespace Framework\Constraints;

/**
 * IsMail class
 * @package Framework\Constraints
 */
class IsMail implements ConstraintInterface
{
    /**
     * message
     *
     * @var string
     */
    private $message;

    /**
     * constructor
     *
     * @param string $message
     */
    public function __construct(string $message) {
        $this->message = $message;
    }

    /**
     * Check if is contain an '@'
     *
     * @param mixed $object
     * @return boolean
     */
    public function valid($object): bool
    {
        if (!strpos($object,'@')) {
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