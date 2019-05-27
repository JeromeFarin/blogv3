<?php

namespace Framework\Constraints;

/**
 * MaxLenght class
 * @package Framework\Constraints
 */
class MaxLenght implements ConstraintInterface
{
    /**
     * value max lenght
     *
     * @var int
     */
    private $value;

    /**
     * message
     *
     * @var string
     */
    private $message;

    /**
     * constructor
     *
     * @param integer $value
     * @param string $message
     */
    public function __construct(int $value, string $message) {
        $this->value = $value;
        $this->message = $message;
    }

    /**
     * check lenght
     *
     * @param mixed $object
     * @return boolean
     */
    public function valid($object): bool
    {
        if (strlen($object) > $this->value) {
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
