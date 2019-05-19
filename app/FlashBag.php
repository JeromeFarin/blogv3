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
    private $flash = [];

    /**
     * Get flash in SESSION and run JS for show flash
     *
     * @return void
     */
    public function getFlash()
    {
        if (isset($_SESSION['flash']) && !empty($_SESSION['flash'])) {
            if (isset($_SESSION['flash']['set']) && !empty($_SESSION['flash']['set'])) {
                unset($_SESSION['flash']['set']);
            } else {
                foreach ($_SESSION['flash'] as $key => $value) {
                    $this->flash[$key]= $value;
                }
                unset($_SESSION['flash']);
            }
        }
        foreach ($this->flash as $value) {
            echo '<script type="text/javascript">',
                'newFlash(\'',$value,'\');',
                '</script>';
        }

        echo '<script type="text/javascript">',
            'flash();',
            '</script>';
    }

    /**
     * Set flash in SESSION
     *
     * @param array $values
     * @return void
     */
    public function setFlash(array $values)
    {
        unset($_SESSION['flash']);
        foreach ($values as $key => $value) {
            $_SESSION['flash'][$key] = $value;
        }
        $_SESSION['flash']['set'] = true;
    }
}
