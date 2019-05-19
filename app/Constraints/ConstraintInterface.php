<?php
namespace Framework\Constraints;

/**
 * ConstraintInterface interface
 * @package Framework\Constraints
 */
interface ConstraintInterface
{
    /**
     * Undocumented function
     *
     * @param mixed $object
     * @return boolean
     */
    public function valid($object): bool;

    /**
     * getMessage
     *
     * @return string
     */
    public function getMessage(): string;
}