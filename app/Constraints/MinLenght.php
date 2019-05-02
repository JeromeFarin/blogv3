<?php

namespace Framework\Constraints;

class MinLenght implements ConstraintInterface
{
    private $value;
    private $message;

    public function __construct(int $value, string $message) {
        $this->value = $value;
        $this->message = $message;
    }

    public function valid($object): bool
    {
        if (strlen($object) < $this->value) {
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
