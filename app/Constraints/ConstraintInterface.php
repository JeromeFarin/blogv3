<?php
namespace Framework\Constraints;

interface ConstraintInterface
{
    public function valid($object): bool;

    public function getMessage(): string;
}