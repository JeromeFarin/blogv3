<?php

namespace Framework;

class Required
{
    private $message;

    /**
     * Required constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function test($value): bool
    {
        return !empty($value);
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}
