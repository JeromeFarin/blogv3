<?php

namespace Framework\Constraints;

class Required implements ConstraintInterface
{
    private $message;

    public function __construct(string $message) {
        $this->message = $message;
    }

    public function valid($object): bool
    {
        
        if (empty($object) || $object === null) {
            return false;
        } else {
            return true;
        }
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}