<?php

namespace Framework;

/**
 * FlashBag class
 * @package Framework
 */
class FlashBag
{
    /**
     * Flash element
     *
     * @var array
     */
    private $messages = [];

    /**
     * Get flash in SESSION and run JS for show flash
     *
     * @return void
     */
    public function getFlash()
    {
        if (isset($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $value) {
                $this->messages[] = $value;
            }
        }

        unset($_SESSION['flash']);

        return $this->messages;
    }

    /**
     * Set flash in SESSION
     *
     * @return void
     */
    public function setFlash(array $messages)
    {
        foreach ($messages as $value) {
            $_SESSION['flash'][] = $value;
        }
    }
}
